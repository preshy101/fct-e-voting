<?php

namespace App\Filament\Widgets;

use App\Models\election;
use App\Models\vote;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class ElectionCandidateVotesStats extends BaseWidget
{
    public ?Model $record = null;

    protected function getStats(): array
    {
        if (!$this->record) {
            return [];
        }

        $election = $this->record;

        // Get total votes cast for this election
        $totalVotes = vote::where('election_id', $election->id)->count();

        // Get votes per candidate
        $candidateVotes = vote::where('election_id', $election->id)
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->selectRaw('candidates.id, candidates.first_name, candidates.last_name, COUNT(*) as vote_count')
            ->groupBy('candidates.id', 'candidates.first_name', 'candidates.last_name')
            ->orderByDesc('vote_count')
            ->get();

        $stats = [];

        // Add total votes stat
        $stats[] = Stat::make('Total Votes Cast', $totalVotes)
            ->description('Total votes for this election')
            ->descriptionIcon('heroicon-o-chart-bar')
            ->color('success');

        // Add individual candidate stats
        foreach ($candidateVotes as $candidate) {
            $percentage = $totalVotes > 0 ? round(($candidate->vote_count / $totalVotes) * 100, 2) : 0;
            
            $stats[] = Stat::make(
                $candidate->first_name . ' ' . $candidate->last_name,
                $candidate->vote_count
            )
                ->description($percentage . '% of total votes')
                ->descriptionIcon('heroicon-o-user')
                ->color('primary');
        }

        return $stats;
    }
}
