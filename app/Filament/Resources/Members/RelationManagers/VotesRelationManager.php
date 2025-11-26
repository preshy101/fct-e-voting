<?php

namespace App\Filament\Resources\Members\RelationManagers;

use App\Filament\Resources\Members\MemberResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class VotesRelationManager extends RelationManager
{
    protected static string $relationship = 'votes';

    protected static ?string $title = 'Votes Cast';

    protected static ?string $recordTitleAttribute = 'election_id';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('election.title')
                    ->label('Election')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('candidate.full_name')
                    ->label('Candidate Voted For')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),

                TextColumn::make('accreditation.token')
                    ->label('Accreditation Token')
                    ->searchable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->label('Vote Cast At')
                    ->dateTime('F j, Y g:i A')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No votes cast yet')
            ->emptyStateDescription('This member has not cast any votes.')
            ->emptyStateIcon('heroicon-o-inbox');
    }

    public function isReadOnly(): bool
    {
        return true;
    }
}
