<?php

namespace App\Filament\Resources\Elections\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VotesExport;

class VotesRelationManager extends RelationManager
{
    protected static string $relationship = 'votes';

    protected static ?string $title = 'Votes Cast';

    protected static ?string $recordTitleAttribute = 'id';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.first_name')
                    ->label('Voter Name')
                    ->formatStateUsing(fn ($state, $record) => ($record->member->first_name ?? 'N/A') . ' ' . ($record->member->last_name ?? ''))
                    ->searchable(query: function ($query, string $search) {
                        $query->where(function ($q) use ($search) {
                            $q->whereHas('member', function ($q2) use ($search) {
                                $q2->where('first_name', 'like', "%{$search}%")
                                   ->orWhere('last_name', 'like', "%{$search}%")
                                   ->orWhere('staff_ID', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                            })
                            ->orWhereHas('candidate', function ($q3) use ($search) {
                                $q3->where('first_name', 'like', "%{$search}%")
                                   ->orWhere('last_name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('accreditation', function ($q4) use ($search) {
                                $q4->where('token', 'like', "%{$search}%");
                            });
                        });
                    })
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('member.staff_ID')
                    ->label('Practice ID')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('member.email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email copied'),

                TextColumn::make('candidate.first_name')
                    ->label('Voted For')
                    ->formatStateUsing(fn ($state, $record) => ($record->candidate->first_name ?? 'N/A') . ' ' . ($record->candidate->last_name ?? ''))
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('accreditation.token')
                    ->label('Token')
                    ->badge()
                    ->color('warning')
                    ->copyable()
                    ->copyMessage('Token copied'),

                TextColumn::make('created_at')
                    ->label('Vote Cast At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->icon('heroicon-o-clock'),
            ])
            ->filters([
                SelectFilter::make('candidate_id')
                    ->label('Filter by Candidate')
                    ->options(function () {
                        return $this->getOwnerRecord()->candidates()
                            ->get()
                            ->mapWithKeys(function ($candidate) {
                                return [$candidate->id => $candidate->first_name . ' ' . $candidate->last_name];
                            });
                    })
                    ->searchable(),
            ])
            ->headerActions([
                Action::make('export_excel')
                    ->label('Export to Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        $election = $this->getOwnerRecord();
                        $votes = $this->getFilteredTableQuery()->with(['member', 'candidate', 'accreditation'])->get();
                        $fileName = 'votes_' . str_replace(' ', '_', $election->title) . '_' . now()->format('Y-m-d_His') . '.xlsx';

                        return Excel::download(
                            new VotesExport($votes, $election->title),
                            $fileName
                        );
                    }),

                Action::make('export_csv')
                    ->label('Export to CSV')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->action(function () {
                        $election = $this->getOwnerRecord();
                        $votes = $this->getFilteredTableQuery()->with(['member', 'candidate', 'accreditation'])->get();
                        $fileName = 'votes_' . str_replace(' ', '_', $election->title) . '_' . now()->format('Y-m-d_His') . '.csv';

                        return Excel::download(
                            new VotesExport($votes, $election->title),
                            $fileName,
                            \Maatwebsite\Excel\Excel::CSV
                        );
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No votes cast yet')
            ->emptyStateDescription('This election has not received any votes.')
            ->emptyStateIcon('heroicon-o-inbox')
            ->poll('30s'); // Auto-refresh every 30 seconds
    }

    public function isReadOnly(): bool
    {
        return true;
    }
}
