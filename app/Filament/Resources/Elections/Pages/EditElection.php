<?php

namespace App\Filament\Resources\Elections\Pages;

use App\Filament\Resources\Elections\ElectionResource;
use App\Models\Setting;
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

        // Save or update election-specific accreditation settings
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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove non-election attributes before updating record
        $electionData = collect($data)->except([
            'candidates',
            'accreditation_start_time',
            'accreditation_end_time',
        ])->toArray();

        return $electionData;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Get the IDs of related candidates
        $data['candidates'] = $this->record->candidates->pluck('id')->toArray();

        // Populate accreditation times from setting
        $setting = Setting::where('election_id', $this->record->id)->first();
        if ($setting) {
            $data['accreditation_start_time'] = $setting->accreditation_start_time;
            $data['accreditation_end_time'] = $setting->accreditation_end_time;
        }

        return $data;
    }
}
