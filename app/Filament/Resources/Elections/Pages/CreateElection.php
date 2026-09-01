<?php

namespace App\Filament\Resources\Elections\Pages;

use App\Filament\Resources\Elections\ElectionResource;
use App\Models\Setting;
use Filament\Resources\Pages\CreateRecord;

class CreateElection extends CreateRecord
{
    protected static string $resource = ElectionResource::class;

    protected function afterCreate(): void
    {
        // Attach candidates if selected
        if (isset($this->data['candidates'])) {
            $this->record->candidates()->attach($this->data['candidates']);
        }

        // Save election-specific accreditation settings
        if (!empty($this->data['accreditation_start_time']) && !empty($this->data['accreditation_end_time'])) {
            Setting::updateOrCreate(
                ['election_id' => $this->record->id],
                [
                    'accreditation_start_time' => $this->data['accreditation_start_time'],
                    'accreditation_end_time' => $this->data['accreditation_end_time'],
                ]
            );
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove non-election attributes before creating record
        $electionData = collect($data)->except([
            'candidates',
            'accreditation_start_time',
            'accreditation_end_time',
        ])->toArray();

        return $electionData;
    }
}
