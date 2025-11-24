<?php

namespace App\Filament\Widgets;

use App\Models\election;
use App\Models\vote;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class VoteCastChart extends ChartWidget
{
    // protected static ?string $heading = 'Election Vote Distribution';
     protected ?string $heading = 'Election Vote Distribution';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public ?string $filter = null;

    public function mount(): void
    {
        parent::mount();

        // Set default filter to the first active election if none is selected
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
        $electionId = $this->filter;

        // If no filter is selected, use the first active election
        if (!$electionId) {
            $firstElection = election::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($firstElection) {
                $electionId = $firstElection->id;
            } else {
                // No active elections found
                return [
                    'datasets' => [
                        [
                            'label' => 'Votes',
                            'data' => [0],
                            'backgroundColor' => '#36A2EB',
                        ],
                    ],
                    'labels' => ['No active elections available'],
                ];
            }
        }

        $results = vote::where('election_id', $electionId)
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->select('candidates.first_name', 'candidates.last_name', DB::raw('COUNT(*) as votes'))
            ->groupBy('candidates.id', 'candidates.first_name', 'candidates.last_name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Votes',
                    'data' => $results->pluck('votes')->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
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
        return election::where('is_active', true)
            ->pluck('title', 'id')
            ->toArray();
    }
}
