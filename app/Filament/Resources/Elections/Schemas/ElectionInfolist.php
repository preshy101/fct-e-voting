<?php

namespace App\Filament\Resources\Elections\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ElectionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Election Information')
            ->schema([
                TextEntry::make('category.title')
                    ->numeric(),
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('start_date')
                    ->dateTime(),
                TextEntry::make('end_date')
                    ->dateTime(),
                TextEntry::make('status')
                    ->badge(),
                IconEntry::make('is_public')
                    ->boolean(),
                TextEntry::make('total_voters')
                    ->numeric(),
                TextEntry::make('votes_cast')
                    ->numeric(),
                TextEntry::make('election_rules')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('organization_name')
                    ->placeholder('-'),
                TextEntry::make('contact_email')
                    ->placeholder('-'),
                TextEntry::make('contact_phone')
                    ->placeholder('-'),
                IconEntry::make('require_voter_verification')
                    ->boolean(),
                IconEntry::make('allow_result_preview')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),

            ])->columns(2)->columnSpan(12),
            ]);
    }
}
