<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

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
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($set, ?string $state, $context) {
                        if ($context === 'create') {
                            $set('slug', Str::slug($state));

                            }
                    }),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required()
                    ->disabled(fn ($context) => $context === 'edit')
                    ->dehydrated(),

                Toggle::make('is_active')
                    ->required(),
                ])->columnSpan(9),

                Section::make('Banner Image')
                ->description('Manage the banner image for the election category.')
                    ->schema([
                        FileUpload::make('image')->nullable()
                        ->image()
                        ->disk('public')
                        ->directory('categories'),
                    ])->columnSpan(3)
                ])->columns(12);


    }
}
