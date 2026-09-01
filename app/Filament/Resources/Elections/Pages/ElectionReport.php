<?php

namespace App\Filament\Resources\Elections\Pages;

use App\Filament\Resources\Elections\ElectionResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

class ElectionReport extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ElectionResource::class;

    protected string $view = 'filament.resources.elections.pages.election-report';
    
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
    
    protected function getViewData(): array
    {
        $election = $this->record;
        $election->load('candidates.votes');
        
        $labels = [];
        $data = [];
        $colors = [];
        foreach($election->candidates as $candidate) {
            $labels[] = $candidate->full_name;
            $data[] = $candidate->votes->count();
            // Generate a distinct color for each candidate based on their ID
            $colors[] = '#' . substr(md5($candidate->id), 0, 6);
        }

        // Votes over time for line chart
        $votesOverTime = $election->votes()
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $lineLabels = $votesOverTime->pluck('date')->toArray();
        $lineData = $votesOverTime->pluck('count')->toArray();

        return [
            'chartLabels' => $labels,
            'chartData' => $data,
            'chartColors' => $colors,
            'lineLabels' => $lineLabels,
            'lineData' => $lineData,
        ];
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadPdf')
                ->label('Download PDF Report')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $election = $this->record;
                    $election->load('candidates.votes');
                    $pdf = Pdf::loadView('pdf.election-report', ['election' => $election]);
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'election-report-' . ($election->slug ?? $election->id) . '.pdf');
                }),
        ];
    }
}
