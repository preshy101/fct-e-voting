<?php

namespace App\Filament\Resources\Elections\Pages;

use App\Filament\Resources\Elections\ElectionResource;
use App\Filament\Widgets\ElectionCandidateVotesStats;
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewElection extends ViewRecord
{
    protected static string $resource = ElectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('accreditationSchedule')
                ->label('Accreditation Schedule')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->slideOver()
                ->modalHeading(fn () => "Accreditation Schedule: {$this->getRecord()->title}")
                ->modalDescription('Configure or update the accreditation time window for this election.')
                ->fillForm(function () {
                    $setting = Setting::where('election_id', $this->getRecord()->id)->first();
                    return [
                        'accreditation_start_time' => $setting?->accreditation_start_time,
                        'accreditation_end_time' => $setting?->accreditation_end_time,
                    ];
                })
                ->form([
                    DateTimePicker::make('accreditation_start_time')
                        ->label('Accreditation Start Time')
                        ->required()
                        ->native(false)
                        ->seconds(false)
                        ->displayFormat('F j, Y g:i A')
                        ->helperText('Select when member accreditation for this election should begin'),

                    DateTimePicker::make('accreditation_end_time')
                        ->label('Accreditation End Time')
                        ->required()
                        ->native(false)
                        ->seconds(false)
                        ->displayFormat('F j, Y g:i A')
                        ->helperText('Select when member accreditation for this election should close')
                        ->after('accreditation_start_time'),
                ])
                ->action(function (array $data) {
                    Setting::updateOrCreate(
                        ['election_id' => $this->getRecord()->id],
                        [
                            'accreditation_start_time' => $data['accreditation_start_time'],
                            'accreditation_end_time' => $data['accreditation_end_time'],
                        ]
                    );

                    Notification::make()
                        ->title('Accreditation schedule updated successfully!')
                        ->success()
                        ->send();
                }),

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
