<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Accreditation Time Settings')
                    ->description('Configure the accreditation time window for specific elections or global defaults')
                    ->schema([
                        Select::make('election_id')
                            ->label('Target Election')
                            ->relationship('election', 'title')
                            ->getOptionLabelFromRecordUsing(fn ($record) => ($record->year ? "[{$record->year}] " : '') . $record->title)
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Select the specific election this accreditation schedule applies to (leave blank for general default)')
                            ->columnSpanFull(),

                        DateTimePicker::make('accreditation_start_time')
                            ->label('Accreditation Start Time')
                            ->required()
                            ->native(false)
                            ->seconds(false)
                            ->displayFormat('F j, Y g:i A')
                            ->helperText('Select when member accreditation should begin')
                            ->columnSpan(1),

                        DateTimePicker::make('accreditation_end_time')
                            ->label('Accreditation End Time')
                            ->required()
                            ->native(false)
                            ->seconds(false)
                            ->displayFormat('F j, Y g:i A')
                            ->helperText('Select when member accreditation should close')
                            ->after('accreditation_start_time')
                            ->columnSpan(1),
                    ])
                    ->columns(2)
            ]);
    }
}
