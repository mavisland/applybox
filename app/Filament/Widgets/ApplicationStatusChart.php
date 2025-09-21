<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ApplicationStatusChart extends ChartWidget
{
    protected ?string $heading = 'Application Status Chart';

    public function getHeading(): ?string
    {
        return __('Application Status Chart');
    }

    protected function getData(): array
    {
        $statusCounts = Application::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $labels = [
            __('Draft'),
            __('Applied'),
            __('Interview'),
            __('Offer'),
            __('Rejected'),
            __('Withdrawn')
        ];
        $data = [];

        foreach ($labels as $label) {
            $status = strtolower($label);
            $data[] = $statusCounts[$status] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => __('Applications by Status'),
                    'data' => $data,
                    'backgroundColor' => [
                        'rgb(65, 105, 225)', // royal blue
                        'rgb(59, 130, 246)', // blue
                        'rgb(16, 185, 129)', // green
                        'rgb(245, 158, 11)', // yellow
                        'rgb(239, 68, 68)',  // red
                        'rgb(107, 114, 128)', // gray
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
