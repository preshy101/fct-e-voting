<?php

namespace App\Filament\Resources\Elections\RelationManagers;

use App\Models\vote;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CandidatesRelationManager extends RelationManager
{
    protected static string $relationship = 'candidates';

    protected static ?string $title = 'Election Candidates & Votes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')->disk('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('votes_count')
                    ->label('Total Votes')
                    ->getStateUsing(function (Model $record): int {
                        return vote::where('election_id', $this->getOwnerRecord()->id)
                            ->where('candidate_id', $record->id)
                            ->count();
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->withCount(['votes' => function ($query) {
                                $query->where('election_id', $this->getOwnerRecord()->id);
                            }])
                            ->orderBy('votes_count', $direction);
                    })
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('vote_percentage')
                    ->label('Vote %')
                    ->getStateUsing(function (Model $record): string {
                        $totalVotes = vote::where('election_id', $this->getOwnerRecord()->id)->count();
                        $candidateVotes = vote::where('election_id', $this->getOwnerRecord()->id)
                            ->where('candidate_id', $record->id)
                            ->count();

                        if ($totalVotes == 0) {
                            return '0%';
                        }

                        $percentage = round(($candidateVotes / $totalVotes) * 100, 2);
                        return $percentage . '%';
                    })
                    ->badge()
                    ->color('primary'),
            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->withCount(['votes' => function ($q) {
                        $q->where('election_id', $this->getOwnerRecord()->id);
                    }])
                    ->orderByDesc('votes_count');
            })
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\AttachAction::make()
                //     ->preloadRecordSelect(),
            ])
            ->actions([
                Action::make('view_voters')
                    ->label('View Voters')
                    ->icon('heroicon-o-users')
                    ->color('info')
                    ->slideOver()
                    ->modalWidth('4xl')
                    ->modalHeading(fn (Model $record): string => 'Voters for ' . $record->first_name . ' ' . $record->last_name)
                    ->modalContent(fn (Model $record): \Illuminate\Contracts\View\View => view('filament.modals.candidate-voters', [
                        'voters' => vote::where('election_id', $this->getOwnerRecord()->id)
                            ->where('candidate_id', $record->id)
                            ->with(['member', 'accreditation'])
                            ->get(),
                        'candidate' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
            ]);
    }
}
