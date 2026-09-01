<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('year')
                            ->label('Filter Dashboard by Election Year')
                            ->options(fn () => \App\Models\election::query()->whereNotNull('year')->distinct()->pluck('year', 'year')->toArray())
                            ->placeholder('All Years (Default)')
                            ->live()
                    ])
                    ->columns(1)
            ]);
    }
}

