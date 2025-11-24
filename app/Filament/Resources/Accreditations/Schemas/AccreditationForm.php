<?php

namespace App\Filament\Resources\Accreditations\Schemas;

use emmanpbarrameda\FilamentTakePictureField\Forms\Components\TakePicture;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AccreditationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Accreditation Information')
                    ->description('Manage accreditation information here.')
                    ->schema([
                Select::make('election_id')
                ->required()->columns(6)
                ->relationship('election', 'title'),

                Select::make('member_id')
                ->relationship('member', 'first_name')
                    ->required()->label('Member')
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('token')
                    ->required(),

                TextInput::make('note')
                    ->default(null),
                TextInput::make('type')
                    ->default(null),
                Toggle::make('is_used')
                    ->required(),
                DateTimePicker::make('used_at'),
                    ])->columnSpan(8),
            Section::make('image Information')
                    ->description('Manage image information here.')
                    ->schema([
                    FileUpload::make('image')
                    ->openable()
                    ->directory('accreditation')
                    ->disk('public')
                    ->image(),
                //     TakePicture::make('photo')
                // ->label('Take Photo')
                // ->useModal() // Opens the camera in a modal
                // ->disk('public') // Specify the disk to save to
                // ->directory('user-photos') // Specify the directory
                // ->columnSpanFull(),
                    ])->columnSpan(4),
            ])->columns(12);
    }
}
