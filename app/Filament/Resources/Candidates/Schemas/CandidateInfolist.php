<?php

namespace App\Filament\Resources\Candidates\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CandidateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Candidate Details')
            ->description('Detailed information about the candidate.')
            ->schema([
                ImageEntry::make('photo')
                    ->disk('public')
                    ->placeholder('-'),
                TextEntry::make('category.title')->label('Category for election')
                    ->numeric(),
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('other_name')
                    ->placeholder('-'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('phone_number'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ])
            ->columns(2)
            ->columnSpanFull(),
            ]);
    }
}
