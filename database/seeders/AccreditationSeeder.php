<?php

namespace Database\Seeders;

use App\Models\accreditation;
use App\Models\election;
use App\Models\member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AccreditationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = member::orderBy('id')->get();
        $elections = election::where('is_active', true)->get();

        if ($members->isEmpty() || $elections->isEmpty()) {
            return;
        }

        // Pre-defined readable tokens for the first few members for easy testing
        $sampleTokens = [
            'AC1001', 'AC1002', 'AC1003', 'AC1004', 'AC1005',
            'AC1006', 'AC1007', 'AC1008', 'AC1009', 'AC1010',
            'AC1011', 'AC1012', 'AC1013', 'AC1014', 'AC1015',
            'AC1016', 'AC1017', 'AC1018', 'AC1019', 'AC1020',
        ];

        // Accredit the first 20 members
        $firstElection = $elections->first();

        foreach ($members->take(20) as $index => $member) {
            $token = $sampleTokens[$index] ?? Str::upper(Str::random(6));

            accreditation::updateOrCreate(
                [
                    'member_id' => $member->id,
                ],
                [
                    'election_id' => $firstElection->id,
                    'token' => $token,
                    'is_approved' => true,
                    'is_used' => false,
                    'used_at' => null,
                    'type' => 'Online',
                    'note' => 'Standard pre-election accreditation',
                ]
            );
        }
    }
}
