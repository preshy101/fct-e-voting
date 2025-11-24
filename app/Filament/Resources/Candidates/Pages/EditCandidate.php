<?php

namespace App\Filament\Resources\Candidates\Pages;

use App\Filament\Resources\Candidates\CandidateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCandidate extends EditRecord
{
    protected static string $resource = CandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Get the first variant (assuming single variant for now)
        $candidateData = $this->record->candidateBio()->first();

        if ($candidateData) {
            // Populate cand$candidateData fields
            $data['biography'] = $candidateData->biography;
            $data['date_of_birth'] = $candidateData->date_of_birth;
            $data['education_background'] = $candidateData->education_background;
            $data['professional_background'] = $candidateData->professional_background;
            $data['campaign_promises'] = $candidateData->campaign_promises;
            $data['achievements'] = $candidateData->achievements;
            $data['social_media_handles'] = $candidateData->social_media_handles;

            // Get attribute values for this variant
            // $attributeValueIds = $variant->attributeValues()->pluck('product_attribute_values.id')->toArray();
            // $data['attribute_values'] = $attributeValueIds;
        }

        return $data;
    }
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
        // Update or create the candidate bio
        $this->record->candidateBio()->updateOrCreate(
            ['candidate_id' => $this->record->id],
            $candidateData
        );

        // Return only candidate data (excluding bio fields)
        return collect($data)->except([
            'biography',
            'education_background',
            'professional_background',
            'campaign_promises',
            'achievements',
            'social_media_handles',
            'date_of_birth',
        ])->toArray();
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove candidateBio fields from product data before saving
        $productData = collect($data)->except([
            'biography',
            'education_background',
            'professional_background',
            'campaign_promises',
            'achievements',
            'social_media_handles',
            'date_of_birth',
        ])->toArray();

        return $productData;
    }

     protected function afterSave(): void
    {
        // Get the created candidate
        $candidate = $this->record;

        // Get candidateBio data from form
        $candidateBioData = [
            'candidate_id' => $candidate->id,
            'biography' => $this->data['biography'] ?? 'Default',
            'education_background' => $this->data['education_background'] ?? null,
            'professional_background' => $this->data['professional_background'],
            'campaign_promises' => $this->data['campaign_promises'] ?? null,
            'achievements' => $this->data['achievements'],
            'social_media_handles' => $this->data['social_media_handles'] ?? null,
            'date_of_birth' => $this->data['date_of_birth'] ?? 0,
        ];

        // Create the product variant
        // $variant = ProductVariant::update($variantData);
        $candidate->candidateBio()->update($candidateBioData);


            // $attributeValueIds = collect(\App\Models\ProductAttribute::with('attributeValues')->get())
            // ->flatMap(function ($attribute) {
            //     return $this->data['attribute_values_' . $attribute->id] ?? [];
            // })->filter()->values()->all();

        // Attach selected attribute values to the variant
        // if (!empty($attributeValueIds)) {
        //     $variant->attributeValues()->sync($attributeValueIds);
        // }

    }

    }
