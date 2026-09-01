<?php

namespace App\Filament\Resources\Elections\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ElectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(12)
                    ->schema([
                        // Left Column: Election Information (8 Cols)
                        Section::make('Election Information')
                            ->description('General configuration and schedule for this election.')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Category')
                                    ->required()
                                    ->relationship('category', 'title')
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('candidates', []))
                                    ->columnSpan(6),

                                TextInput::make('title')
                                    ->label('Election Title')
                                    ->required()
                                    ->placeholder('e.g. 2026 Executive Chairman Election')
                                    ->columnSpan(6),

                                Select::make('year')
                                    ->label('Election Year')
                                    ->options(function () {
                                        $currentYear = (int) date('Y');
                                        $years = [];
                                        for ($y = $currentYear; $y <= $currentYear + 20; $y++) {
                                            $years[$y] = (string) $y;
                                        }
                                        return $years;
                                    })
                                    ->default(date('Y'))
                                    ->searchable()
                                    ->required()
                                    ->columnSpan(4),

                                DateTimePicker::make('start_date')
                                    ->label('Voting Start Date & Time')
                                    ->required()
                                    ->native(false)
                                    ->seconds(false)
                                    ->displayFormat('F j, Y g:i A')
                                    ->columnSpan(4),

                                DateTimePicker::make('end_date')
                                    ->label('Voting End Date & Time')
                                    ->required()
                                    ->native(false)
                                    ->seconds(false)
                                    ->displayFormat('F j, Y g:i A')
                                    ->after('start_date')
                                    ->columnSpan(4),

                                Select::make('status')
                                    ->label('Election Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'upcoming' => 'Upcoming',
                                        'active' => 'Active',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->default('active')
                                    ->required()
                                    ->columnSpan(12),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->placeholder('Provide an overview or purpose of this election...')
                                    ->default(null)
                                    ->columnSpanFull(),

                                RichEditor::make('election_rules')
                                    ->label('Election Rules & Guidelines')
                                    ->placeholder('Enter voting rules and eligibility instructions...')
                                    ->default(null)
                                    ->columnSpanFull(),
                            ])
                            ->columns(12)
                            ->columnSpan(8),

                        // Right Column: Candidate Information & Accreditation Information (4 Cols)
                        Group::make([
                            Section::make('Candidate Information')
                                ->description('Select candidates contesting in this election.')
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
                                        ->columns(1)
                                        ->searchable()
                                        ->columnSpanFull()
                                        ->hidden(fn (callable $get) => !$get('category_id'))
                                        ->helperText('Please select the candidates contesting in this election.'),
                                ])
                                ->columnSpanFull(),

                            Section::make('Accreditation Information')
                                ->description('Set the required voter accreditation start & end window for this election.')
                                ->icon('heroicon-o-shield-check')
                                ->extraAttributes([
                                    'class' => 'ring-2 ring-[#008751] bg-[#008751]/5 dark:bg-[#008751]/10 rounded-2xl border-2 border-[#008751] shadow-sm mt-4',
                                    'style' => 'border-color: #008751 !important;',
                                ])
                                ->schema([
                                    DateTimePicker::make('accreditation_start_time')
                                        ->label('Accreditation Start Date & Time')
                                        ->required()
                                        ->native(false)
                                        ->seconds(false)
                                        ->displayFormat('F j, Y g:i A')
                                        ->helperText('When voter accreditation begins.')
                                        ->columnSpanFull(),

                                    DateTimePicker::make('accreditation_end_time')
                                        ->label('Accreditation End Date & Time')
                                        ->required()
                                        ->native(false)
                                        ->seconds(false)
                                        ->displayFormat('F j, Y g:i A')
                                        ->after('accreditation_start_time')
                                        ->helperText('When voter accreditation closes.')
                                        ->columnSpanFull(),
                                ])
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(4),

                        // Bottom Section: Election Controls & Verification Rules (Full 12 Cols)
                        Section::make('Election Controls & Verification Rules')
                            ->description('Set accreditation requirements, live previews, and visibility for this election.')
                            ->schema([
                                Toggle::make('require_voter_verification')
                                    ->label('Require Voter Verification (Accreditation)')
                                    ->helperText('When enabled, voters MUST have an approved accreditation token for this election to vote. If disabled, no accreditation check will be done and members can vote directly.')
                                    ->default(true)
                                    ->required()
                                    ->columnSpan(6),

                                Toggle::make('allow_result_preview')
                                    ->label('Allow Result Preview')
                                    ->helperText('When enabled, allows voters and public viewers to preview vote counts and provisional results before official conclusion.')
                                    ->default(false)
                                    ->required()
                                    ->columnSpan(6),

                                Toggle::make('preview_enabled')
                                    ->label('Enable Live Preview')
                                    ->helperText('When enabled, activates the live ballot preview screen for this election so voters can preview the candidate ballot.')
                                    ->default(false)
                                    ->required()
                                    ->columnSpan(6),

                                Toggle::make('is_active')
                                    ->label('Is Active')
                                    ->helperText('Controls whether this election is active and accepting votes. If disabled, the election is locked.')
                                    ->default(true)
                                    ->required()
                                    ->columnSpan(6),

                                Toggle::make('is_public')
                                    ->label('Is Public')
                                    ->helperText('When enabled, this election is published and visible on the portal elections listing.')
                                    ->default(true)
                                    ->required()
                                    ->columnSpan(6),
                            ])
                            ->columns(12)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
