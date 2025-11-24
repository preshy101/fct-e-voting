<?php

namespace App\Imports;

use App\Models\member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class MembersImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new member([
            'first_name' => $row['first_name'] ?? $row['first_name'] ?? null,
            'last_name' => $row['last_name'] ?? $row['last_name'] ?? null,
            'other_name' => $row['other_name'] ?? $row['other_name'] ?? null,
            'email' => $row['email'] ?? $row['email'] ?? null,
            'phone_number' => $row['phone_number'] ?? $row['phone_number'] ?? null,
            'practice_id' => $row['practice_id'] ?? $row['practice_id'] ?? $row['practice_ID'] ?? null,
            'grade' => $row['grade'] ?? $row['grade'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.email' => [
                'required',
                'email',
                Rule::unique('members', 'email')
            ],
            '*.first_name' => 'required|string|max:255',
            '*.last_name' => 'required|string|max:255',
            '*.phone_number' => 'nullable|string|max:20',
            '*.practice_id' => 'nullable|string|max:255',
            '*.grade' => 'nullable|string|max:100',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.email.required' => 'Email is required',
            '*.email.unique' => 'Duplicate email found: :input',
            '*.first_name.required' => 'First name is required',
            '*.last_name.required' => 'Last name is required',
        ];
    }
}
