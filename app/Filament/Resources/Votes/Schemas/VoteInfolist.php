<?php

namespace App\Filament\Resources\Votes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Vote Information')
            ->schema([
                TextEntry::make('election.title')
                    ->numeric(),
                TextEntry::make('member.first_name')
                    ->numeric(),
                TextEntry::make('accreditation.token')->label('Accreditation token')
                    ->numeric(),
                TextEntry::make('candidate.first_name')
                    ->numeric(),
                TextEntry::make('token')
                    ->placeholder('-'),
                TextEntry::make('created_at')->label('Voted At')
                    ->dateTime()
                    ->placeholder('-'),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
            ])->columns(2)->columnSpan(8),
            ]);
    }
}
