<?php

namespace App\Filament\Resources\Elections\Pages;

use App\Filament\Resources\Elections\ElectionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditElection extends EditRecord
{
    protected static string $resource = ElectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
    protected function afterSave(): void
        {
            if (isset($this->data['candidates'])) {
                $this->record->candidates()->sync($this->data['candidates']);
            }
        }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove candidateBio fields from product data before saving
        $candidateData = collect($data)->except([
            'candidates'
        ])->toArray();

        return $candidateData;
    }

     protected function mutateFormDataBeforeFill(array $data): array
    {
        // Get the IDs of related candidates
        $data['candidates'] = $this->record->candidates->pluck('id')->toArray();

        return $data;
    }
}
