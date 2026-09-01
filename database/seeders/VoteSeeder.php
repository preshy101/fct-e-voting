<?php

namespace Database\Seeders;

use App\Models\accreditation;
use App\Models\election;
use App\Models\member;
use App\Models\vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elections = election::with('candidates')->where('is_active', true)->get();
        $accreditations = accreditation::with('member')->where('is_approved', true)->get();

        if ($elections->isEmpty() || $accreditations->isEmpty()) {
            return;
        }

        // We will cast votes for the first 10 accredited members
        // Leaving members 11-20 accredited with is_used = false for live testing!
        $votersToCast = $accreditations->take(10);

        foreach ($elections as $election) {
            $candidates = $election->candidates;
            if ($candidates->isEmpty()) {
                continue;
            }

            $candidateCount = $candidates->count();

            foreach ($votersToCast as $index => $accreditation) {
                // Distribute votes across candidates
                $candidate = $candidates[$index % $candidateCount];

                // Check if already voted
                $existingVote = vote::where('election_id', $election->id)
                    ->where('member_id', $accreditation->member_id)
                    ->first();

                if (!$existingVote) {
                    $voteToken = 'VT' . str_pad($election->id, 2, '0', STR_PAD_LEFT) . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

                    vote::create([
                        'election_id' => $election->id,
                        'member_id' => $accreditation->member_id,
                        'accreditation_id' => $accreditation->id,
                        'candidate_id' => $candidate->id,
                        'token' => $voteToken,
                        'created_at' => now()->subHours(rand(1, 24)),
                        'updated_at' => now()->subHours(rand(1, 24)),
                    ]);
                }

                // Mark accreditation as used
                $accreditation->update([
                    'is_used' => true,
                    'used_at' => now()->subHours(rand(1, 24)),
                ]);
            }

            // Update election counts
            $election->update([
                'total_voters' => member::count(),
                'votes_cast' => vote::where('election_id', $election->id)->count(),
            ]);
        }
    }
}
