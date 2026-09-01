<?php

namespace App\Filament\Resources\Members\Schemas;

use Dom\Text;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Member Information')
                    ->description('Manage member information here.')
                      
                    ->schema([
                TextInput::make('staff_id')
                    ->required()->label('Practice ID')
                    ->default(null),

                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('other_name')
                    ->default(null),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone_number')
                    ->required()->numeric()
                    ->columnSpanFull(),
                ])->columnSpan(8),
                    Section::make('Passport Photograph')
                    ->description('Manage member passport photograph here.')
                    ->schema([
                        FileUpload::make('photo')->image()->imageEditor()
                            ->default(null),
                    ])->columnSpan(4),
            ])->columns(12);
    }
}
