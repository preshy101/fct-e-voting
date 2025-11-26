<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema(self::getSchema());
    }

    public static function getSchema(): array
    {
        return [
            ComponentsSection::make('Accreditation Time Settings')
                ->description('Configure the time window for member accreditation')
                ->schema([
                    DateTimePicker::make('accreditation_start_time')
                        ->label('Accreditation Start Time')
                        ->required()
                        ->native(false)
                        ->seconds(false)
                        ->displayFormat('F j, Y g:i A')
                        ->helperText('Select when accreditation should begin')
                        ->columnSpanFull(),

                    DateTimePicker::make('accreditation_end_time')
                        ->label('Accreditation End Time')
                        ->required()
                        ->native(false)
                        ->seconds(false)
                        ->displayFormat('F j, Y g:i A')
                        ->helperText('Select when accreditation should end')
                        ->after('accreditation_start_time')
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),
        ];
    }
}
