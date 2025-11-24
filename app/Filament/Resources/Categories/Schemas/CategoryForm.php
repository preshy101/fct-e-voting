<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Election Category')
                ->description('Manage election categories here.')
                    ->schema([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required(),

                Toggle::make('is_active')
                    ->required(),
                ])->columns(9),

                Section::make('Banner Image')
                ->description('Manage the banner image for the election category.')
                    ->schema([
                        FileUpload::make('image')->nullable()
                        ->image(),
                    ])->columns(1)
                ])->columns(2);


    }
}
