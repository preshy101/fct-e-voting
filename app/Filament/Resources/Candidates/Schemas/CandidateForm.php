<?php

namespace App\Filament\Resources\Candidates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use GuzzleHttp\Psr7\UploadedFile;

class CandidateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Candidate Information')
                    ->description('Manage candidate information here.')
                    ->schema([
                Select::make('category_id')
                    ->required()->columns(6)
                    ->relationship('category', 'title'),
                     Grid::make(2)
                            ->schema([
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('other_name')
                    ->default(null),
                            ]),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()->unique()
                    ->required(),
                TextInput::make('phone_number')->numeric()
                    ->required()->unique(),
                Toggle::make('is_active')
                            ->default(true)

            ])->columnSpan(8),

            Section::make('Passport Photograph')
                    ->description('Manage passport photograph here.')
                    ->schema([
                        FileUpload::make('photo')
                        ->default(null)
                        ->image()
                        ->editableSvgs(true)
                        ->directory('passports')
                        ->disk('public')
                        ->openable()
                        ->visibility('public')
                        ->helperText('Upload image in jpg, png formats only. Max size: 2MB.'),
                    ])->columnSpan(4)->collapsible() // Makes the section collapsible
                                    ->compact(),


               Section::make('Bio Data (optional)')
                    ->description('Manage bio data here.')
                    ->schema([
                        DatePicker::make('date_of_birth')->required()
                            ->default(null),
                        Textarea::make('biography')
                            ->default(null),
                        Textarea::make('education_background')
                            ->default(null),
                        Textarea::make('professional_background')
                            ->default(null),
                        Textarea::make('campaign_promises')
                            ->default(null),
                        Textarea::make('achievements')
                            ->default(null),
                        Textarea::make('social_media_handles')
                            ->helperText('Enter social media handles separated by commas.
                            (e.g., twitter: @candidate, facebook: /candidate)')
                            ->default(null),
                    ])->columnSpan(12)->collapsible() // Makes the section collapsible
                                    ->collapsed() // Starts in collapsed state
                                    ->compact(),
            ])->columns(12);
    }
}
