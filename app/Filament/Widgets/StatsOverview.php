<?php

namespace App\Filament\Widgets;

use App\Models\accreditation;
use App\Models\election;
use App\Models\member;
use App\Models\vote;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class StatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 12;

    protected function getStats(): array
    {
        $year = $this->filters['year'] ?? null;

        $electionsQuery = election::query()
            ->when($year, fn($q) => $q->where('year', $year));

        $accreditationsQuery = accreditation::query()
            ->when($year, fn($q) => $q->whereHas('election', fn($eq) => $eq->where('year', $year)));

        $votesQuery = vote::query()
            ->when($year, fn($q) => $q->whereHas('election', fn($eq) => $eq->where('year', $year)));

        return [
            Stat::make('Total Members', member::count())
                ->description('All chapter members')
                ->descriptionIcon('heroicon-m-user')
                ->chart(
                    [7, 2, 10, 3, 15, 4, 17]
                )
                ->color('primary'),
            Stat::make('Total Elections', $electionsQuery->count())
                ->description($year ? "Elections held in $year" : 'All elections held')
                ->descriptionIcon('heroicon-m-archive-box')
                ->chart(
                    [20, 2, 10, 3, 5, 4, 7]
                )
                ->color('dark'),
            Stat::make('Total Accreditation', $accreditationsQuery->count())
                ->description($year ? "Accreditations in $year" : 'All accreditation')
                ->descriptionIcon('heroicon-m-check-badge')
                ->chart(
                     accreditation::query()
                        ->when($year, fn($q) => $q->whereHas('election', fn($eq) => $eq->where('year', $year)))
                        ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                        ->where('created_at', '>=', now()->subDays(7))
                        ->groupBy('created_at')
                        ->orderBy('created_at', 'asc')
                        ->pluck('count')
                        ->toArray()
                )
                ->color('warning'),
            Stat::make('Total Votes cast', $votesQuery->count())
                ->description($year ? "Votes casted in $year" : 'All votes casted')
                ->descriptionIcon('heroicon-m-document-arrow-down')
                ->chart(
                     vote::query()
                        ->when($year, fn($q) => $q->whereHas('election', fn($eq) => $eq->where('year', $year)))
                        ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                        ->where('created_at', '>=', now()->subDays(7))
                        ->groupBy('created_at')
                        ->orderBy('created_at', 'asc')
                        ->pluck('count')
                        ->toArray()
                )
                ->color('success'),
        ];
    }
}
