<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingResource;
use App\Models\Setting;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    public function mount(): void
    {
        parent::mount();

        // Ensure at least one settings record exists
        if (Setting::count() === 0) {
            Setting::create([
                'accreditation_start_time' => null,
                'accreditation_end_time' => null,
            ]);
        }
    }

    protected function getHeaderActions(): array
    {
        // Only show create action if no settings exist
        if (Setting::count() === 0) {
            return [
                CreateAction::make(),
            ];
        }

        return [];
    }
}
