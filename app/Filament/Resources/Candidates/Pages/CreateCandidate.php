<?php

namespace App\Filament\Resources\Candidates\Pages;

use App\Filament\Resources\Candidates\CandidateResource;
use App\Models\candidateBio;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCandidate extends CreateRecord
{
    protected static string $resource = CandidateResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove bio fields from candidate data before saving
        $candidateData = collect($data)->except([
            'biography',
            'education_background',
            'professional_background',
            'campaign_promises',
            'achievements',
            'social_media_handles',
            'date_of_birth',
        ])->toArray();

        return $candidateData;
    }

    protected function afterCreate(): void
    {
       // Get the created candidate
        $candidate = $this->record; 
        // Get bio data from form
        $bioData = [
            'candidate_id' => $candidate->id,
            'biography' => json_encode($this->data['biography']) ?? null,
            'date_of_birth' => $this->data['date_of_birth'] ?? null,
            'education_background' => $this->data['education_background'] ?? null,
            'professional_background' => $this->data['professional_background'] ?? null,
            'campaign_promises' => $this->data['campaign_promises'] ?? null,
            'achievements' => $this->data['achievements'] ?? null,
            'social_media_handles' => $this->data['social_media_handles'] ?? null,
        ];

        // Create the candidate bio
        $bio = candidateBio::create($bioData);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Candidate Created Successfully!')
            ->body("The Candidate '{$this->record->name}' has been created successfully.")
            ->duration(5000) // 5 seconds
            ->icon('heroicon-o-check-circle')
            ->iconColor('success');
    }
}

