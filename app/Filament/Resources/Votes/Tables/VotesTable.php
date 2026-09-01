<?php

namespace App\Filament\Resources\Votes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Vote Cast At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),

                TextColumn::make('election.title')
                    ->label('Election')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('member.first_name')
                    ->label('Voter Name')
                    ->formatStateUsing(fn ($state, $record) => ($record->member->first_name ?? 'N/A') . ' ' . ($record->member->last_name ?? ''))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('member.staff_ID')
                    ->label('Practice ID')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('candidate.first_name')
                    ->label('Voted For')
                    ->formatStateUsing(fn ($state, $record) => ($record->candidate->first_name ?? 'N/A') . ' ' . ($record->candidate->last_name ?? ''))
                    ->badge()
                    ->color('success')
                    ->sortable(),

                TextColumn::make('token')
                    ->label('Token')
                    ->badge()
                    ->color('warning')
                    ->copyable()
                    ->searchable(),

                TextColumn::make('updated_at')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
