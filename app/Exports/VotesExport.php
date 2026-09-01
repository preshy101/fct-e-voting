<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;

class VotesExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected Collection $votes;
    protected string $electionName;

    public function __construct(Collection $votes, string $electionName = 'Votes')
    {
        $this->votes = $votes;
        $this->electionName = $electionName;
    }

    public function collection()
    {
        return $this->votes;
    }

    public function headings(): array
    {
        return [
            'Vote ID',
            'Voter First Name',
            'Voter Last Name',
            'Voter Email',
            'Practice ID',
            'Candidate First Name',
            'Candidate Last Name',
            'Token',
            'Vote Cast At',
        ];
    }

    public function map($vote): array
    {
        return [
            $vote->id,
            $vote->member->first_name ?? 'N/A',
            $vote->member->last_name ?? '',
            $vote->member->email ?? 'N/A',
            $vote->member->staff_ID ?? 'N/A',
            $vote->candidate->first_name ?? 'N/A',
            $vote->candidate->last_name ?? '',
            $vote->accreditation->token ?? 'N/A',
            $vote->created_at?->format('M d, Y h:i A'),
        ];
    }

    public function title(): string
    {
        return substr($this->electionName, 0, 31); // Excel sheet name limit
    }
}
