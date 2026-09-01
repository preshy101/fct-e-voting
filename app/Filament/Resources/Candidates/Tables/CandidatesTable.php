<?php

namespace App\Filament\Resources\Candidates\Tables;

use App\Models\candidate;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CandidatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            ImageColumn::make('photo')
                ->disk('public')
                ->circular(),
            TextColumn::make('category.title')
                ->label('Category')
                ->sortable()
                ->searchable(),
            TextColumn::make('first_name')
                ->sortable()
                ->searchable(),
            TextColumn::make('last_name')
                ->sortable()
                ->searchable(),
            TextColumn::make('email')
                ->sortable()
                ->searchable(),
            TextColumn::make('phone_number')
                ->sortable(),
            ToggleColumn::make('is_active')
                ->label('Status'),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ])
        ->defaultSort('created_at', 'desc')
        ->filters([
            // Add any filters you need
        ])
    //     ->recordActions([
    //        Action::make('edit')
    // ->url(fn (candidate $record): string => route('filament.admin.resources.candidates.edit', $record))
    // ,

    //     Action::make('delete')
    //         ->requiresConfirmation()
    //         ->action(fn (candidate $record) => $record->delete())
    //         ->color('danger'),
    //      ])
    //     ->toolbarActions([
    //        BulkActionGroup::make([
    //             BulkAction::make('delete')
    //                 ->requiresConfirmation()
    //                 ->action(fn (Collection $records) => $records->each->delete())
    //            ->successNotificationTitle('Deleted Candidates')
    //             ->failureNotificationTitle(function (int $successCount, int $totalCount): string {
    //                 if ($successCount) {
    //                     return "{$successCount} of {$totalCount} Candidates deleted";
    //                 }

    //                 return 'Failed to delete any Candidates';
    //             })
    //         ]),

    //     ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
