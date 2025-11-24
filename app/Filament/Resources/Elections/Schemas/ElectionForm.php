<?php

namespace App\Filament\Resources\Elections\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ElectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Election Information')
                    ->description('Manage election information here.')
                    ->schema([
                Select::make('category_id')
                    ->required()->columns(6)
                    ->relationship('category', 'title')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('candidates', [])),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('start_date')
                    ->required(),
                DateTimePicker::make('end_date')
                    ->required(),

                Toggle::make('is_public')
                    ->required(),
                // TextInput::make('total_voters')
                //     ->required()
                //     ->numeric()
                //     ->default(0),
                // TextInput::make('votes_cast')
                //     ->required()
                //     ->numeric()
                //     ->default(0),
                RichEditor::make('election_rules')
                    ->default(null)
                    ->columnSpanFull(),
                // TextInput::make('organization_name')
                //     ->default(null),
                // TextInput::make('contact_email')
                //     ->email()
                //     ->default(null),
                // TextInput::make('contact_phone')
                //     ->tel()
                //     ->default(null),
                    Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'upcoming' => 'Upcoming',
            'active' => 'Active',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ])
                    ->default('active')
                    ->required(),
                Toggle::make('require_voter_verification')
                    ->required(),
                Toggle::make('allow_result_preview')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                    ])->columnSpan(8),

                Section::make('Candidate Information')
                    ->description('Select candidates from the chosen category.')
                    ->schema([
                        CheckboxList::make('candidates')
                            ->label('Available Candidates')
                            ->options(function (callable $get) {
                                $categoryId = $get('category_id');

                                if (!$categoryId) {
                                    return [];
                                }

                                return \App\Models\candidate::where('is_active', true)
                                    ->where('category_id', $categoryId)
                                    ->get()
                                    ->pluck('full_name', 'id')
                                    ->toArray();
                            })
                            ->required()
                            ->minItems(1)
                            ->reactive()
                            ->columns(2)->searchable()
                            ->gridDirection('row')
                            ->columnSpanFull()
                            ->hidden(fn (callable $get) => !$get('category_id'))
                            ->helperText('Please select at least 2 candidates for this election.')
                    ])
                    ->columnSpan(4)
            ])->columns(12);
    }
}
