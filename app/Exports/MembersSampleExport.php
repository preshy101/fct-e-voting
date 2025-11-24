<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MembersSampleExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'John',
                'Doe',
                'Michael',
                'john.doe@example.com',
                '+1234567890',
                'PRC-001',
                'Senior'
            ],
            [
                'Jane',
                'Smith',
                'Marie',
                'jane.smith@example.com',
                '+1234567891',
                'PRC-002',
                'Junior'
            ],
            [
                'Robert',
                'Johnson',
                '',
                'robert.johnson@example.com',
                '+1234567892',
                'PRC-003',
                'Mid-level'
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'first_name',
            'last_name',
            'other_name',
            'email',
            'phone_number',
            'practice_id',
            'grade'
        ];
    }
}
