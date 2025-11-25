<?php

namespace App\Filament\Resources\Members\Tables;

use App\Filament\Imports\MemberImporter;
use EightyNine\ExcelImport\SampleExcelExport;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('other_name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('photo')
                    ->searchable(),
                TextColumn::make('practice_ID')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Import action
                  \EightyNine\ExcelImport\ExcelImportAction::make()->slideOver()
                ->color("warning")->validateUsing([
                'first_name' => 'required',
                'last_name' => 'required',
                // 'practice_ID' => ['required','numeric'],
            ]) ->sampleExcel(
                sampleData: [
                    ['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john@doe.com', 'grade' => 'Associate', 'practice_ID' => '015737'],
                    ['first_name' => 'Jane', 'last_name' => 'Doe', 'email' => 'jane@doe.com', 'grade' => 'Associate', 'practice_ID' => '015333'],
                ],
                fileName: 'sample.xlsx',
                exportClass: SampleExcelExport::class,
                sampleButtonLabel: 'Download Sample',
                customiseActionUsing: fn(Action $action) => $action->color('secondary')
                    ->icon('heroicon-m-clipboard')
                    ->requiresConfirmation(),
            ),

                // // Export sample action
                // Action::make('downloadSample')
                //     ->label('Download Sample')
                //     ->color('success')
                //     ->icon('heroicon-o-document-arrow-down')
                //     ->action(function () {
                //         return response()->download(
                //             public_path('samples/members-import-sample.xlsx'),
                //             'members-import-sample.xlsx'
                //         );
                //     })
                //     ->requiresConfirmation(false),
            ])
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
