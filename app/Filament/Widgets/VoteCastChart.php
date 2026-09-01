<?php

namespace App\Filament\Widgets;

use App\Models\election;
use App\Models\vote;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class VoteCastChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Election Vote Distribution';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public ?string $filter = null;

    public function mount(): void
    {
        parent::mount();

        if (!$this->filter) {
            $firstElection = election::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($firstElection) {
                $this->filter = (string) $firstElection->id;
            }
        }
    }

    protected function getData(): array
    {
        $year = $this->filters['year'] ?? null;
        $electionId = $this->filter;

        $electionsQuery = election::query()
            ->when($year, fn($q) => $q->where('year', $year))
            ->orderBy('created_at', 'desc');

        if ($year && $electionId) {
            $isValid = (clone $electionsQuery)->where('id', $electionId)->exists();
            if (!$isValid) {
                $electionId = null;
            }
        }

        if (!$electionId) {
            $firstElection = (clone $electionsQuery)->first();

            if ($firstElection) {
                $electionId = $firstElection->id;
                $this->filter = (string) $electionId;
            } else {
                return [
                    'datasets' => [
                        [
                            'label' => 'Votes',
                            'data' => [0],
                            'backgroundColor' => '#008751',
                        ],
                    ],
                    'labels' => [$year ? "No elections held in {$year}" : 'No elections available'],
                ];
            }
        }

        $currentElection = election::find($electionId);
        $results = vote::where('election_id', $electionId)
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->select('candidates.first_name', 'candidates.last_name', DB::raw('COUNT(*) as votes'))
            ->groupBy('candidates.id', 'candidates.first_name', 'candidates.last_name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => $currentElection ? "Votes for {$currentElection->title}" : 'Votes',
                    'data' => $results->pluck('votes')->toArray(),
                    'backgroundColor' => '#008751',
                    'borderColor' => '#008751',
                ],
            ],
            'labels' => $results->map(fn($item) => $item->first_name . ' ' . $item->last_name)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFilters(): ?array
    {
        $year = $this->filters['year'] ?? null;
        
        return election::query()
            ->when($year, fn($query) => $query->where('year', $year))
            ->orderBy('created_at', 'desc')
            ->pluck('title', 'id')
            ->toArray();
    }
}
