<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('accreditation_start_time')
                    ->label('Accreditation Start Time')
                    ->dateTime('F j, Y g:i A')
                    ->placeholder('Not set')
                    ->sortable(),
                    
                TextColumn::make('accreditation_end_time')
                    ->label('Accreditation End Time')
                    ->dateTime('F j, Y g:i A')
                    ->placeholder('Not set')
                    ->sortable(),
                    
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('F j, Y g:i A')
                    ->sortable(),
            ])
            
            ->paginated(false);
    }
}
