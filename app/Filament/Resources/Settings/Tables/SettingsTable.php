<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('election.title')
                    ->label('Election')
                    ->placeholder('Global Default (All Elections)')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('election.year')
                    ->label('Year')
                    ->badge()
                    ->color('primary')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('accreditation_start_time')
                    ->label('Accreditation Opens')
                    ->dateTime('M d, Y h:i A')
                    ->placeholder('Not set')
                    ->sortable(),

                TextColumn::make('accreditation_end_time')
                    ->label('Accreditation Closes')
                    ->dateTime('M d, Y h:i A')
                    ->placeholder('Not set')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        if (!$record->accreditation_start_time || !$record->accreditation_end_time) {
                            return 'Not Configured';
                        }
                        $now = now();
                        if ($now->lt($record->accreditation_start_time)) {
                            return 'Upcoming';
                        }
                        if ($now->gt($record->accreditation_end_time)) {
                            return 'Ended';
                        }
                        return 'Active Now';
                    })
                    ->colors([
                        'success' => 'Active Now',
                        'warning' => 'Upcoming',
                        'danger' => 'Ended',
                        'gray' => 'Not Configured',
                    ]),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('year')
                    ->label('Filter by Year')
                    ->relationship('election', 'year')
                    ->options(fn () => \App\Models\election::query()->whereNotNull('year')->distinct()->pluck('year', 'year')->toArray()),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
