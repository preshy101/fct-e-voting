<?php

namespace App\Filament\Resources\Elections\Pages;

use App\Filament\Resources\Elections\ElectionResource;
use App\Filament\Widgets\ElectionCandidateVotesStats;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewElection extends ViewRecord
{
    protected static string $resource = ElectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ElectionCandidateVotesStats::class,
        ];
    }
}
