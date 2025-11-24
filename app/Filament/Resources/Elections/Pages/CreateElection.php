<?php

namespace App\Filament\Resources\Elections\Pages;

use App\Filament\Resources\Elections\ElectionResource;
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
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove bio fields from candidate data before saving
        $candidateData = collect($data)->except([
            'candidates',
        ])->toArray();

        return $candidateData;
    }
}
