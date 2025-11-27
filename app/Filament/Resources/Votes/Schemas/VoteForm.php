<?php

namespace App\Filament\Resources\Votes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Accreditation Information')
                    ->description('Manage accreditation information here.')
                    ->schema([
                Select::make('election_id')
                        ->relationship('election', 'title')
                    ->required(),
                Select::make('member_id')
                        ->relationship('member', 'first_name')
                    ->required(),
                Select::make('accreditation_id')
                    ->relationship('accreditation', 'token')
                    ->required(),
                Select::make('candidate_id')
                        ->relationship('candidate', 'first_name')
                    ->required(),
                TextInput::make('token')
                    ->default(null),
            ])->columnSpan(8),
            ])->columns(12);
    }
}
