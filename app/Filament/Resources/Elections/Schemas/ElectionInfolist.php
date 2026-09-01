<?php

namespace App\Filament\Resources\Elections\Schemas;

use App\Models\Setting;
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
                Section::make('Election Overview')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Title')
                            ->weight('bold'),

                        TextEntry::make('category.title')
                            ->label('Category'),

                        TextEntry::make('year')
                            ->label('Year')
                            ->badge()
                            ->color('primary')
                            ->placeholder('N/A'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge(),

                        TextEntry::make('start_date')
                            ->label('Voting Starts')
                            ->dateTime('M d, Y h:i A'),

                        TextEntry::make('end_date')
                            ->label('Voting Ends')
                            ->dateTime('M d, Y h:i A'),

                        TextEntry::make('accreditation_schedule')
                            ->label('Accreditation Schedule')
                            ->getStateUsing(function ($record) {
                                $setting = Setting::where('election_id', $record->id)->first();
                                if (!$setting || !$setting->accreditation_start_time || !$setting->accreditation_end_time) {
                                    return 'Not Configured (Uses Global Default)';
                                }
                                return $setting->accreditation_start_time->format('M d, Y h:i A') . ' to ' . $setting->accreditation_end_time->format('M d, Y h:i A');
                            })
                            ->badge()
                            ->color(function ($record) {
                                $setting = Setting::where('election_id', $record->id)->first();
                                if (!$setting || !$setting->accreditation_start_time || !$setting->accreditation_end_time) {
                                    return 'gray';
                                }
                                $now = now();
                                if ($now->lt($setting->accreditation_start_time)) return 'warning';
                                if ($now->gt($setting->accreditation_end_time)) return 'danger';
                                return 'success';
                            })
                            ->columnSpan(2),

                        TextEntry::make('total_voters')
                            ->label('Total Voters')
                            ->numeric(),

                        TextEntry::make('votes_cast')
                            ->label('Votes Cast')
                            ->numeric(),

                        TextEntry::make('description')
                            ->label('Description')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        TextEntry::make('election_rules')
                            ->label('Election Rules')
                            ->html()
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(12),

                Section::make('Access Controls & Verification')
                    ->schema([
                        IconEntry::make('require_voter_verification')
                            ->label('Require Voter Verification (Accreditation)')
                            ->boolean(),

                        IconEntry::make('allow_result_preview')
                            ->label('Allow Result Preview')
                            ->boolean(),

                        IconEntry::make('preview_enabled')
                            ->label('Live Preview Enabled')
                            ->boolean(),

                        IconEntry::make('is_active')
                            ->label('Is Active')
                            ->boolean(),

                        IconEntry::make('is_public')
                            ->label('Is Public')
                            ->boolean(),
                    ])
                    ->columns(3)
                    ->columnSpan(12),
            ]);
    }
}
