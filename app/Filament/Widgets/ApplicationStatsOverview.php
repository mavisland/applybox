<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use App\Models\Company;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApplicationStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Applications'), Application::count())
                ->description(__('Total job applications'))
                ->icon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make(__('Draft Applications'), Application::whereIn('status', ['draft'])->count())
                ->description(__('Applications to be done'))
                ->icon('heroicon-m-arrow-path')
                ->color('warning'),

            Stat::make(__('Active Applications'), Application::whereIn('status', ['applied', 'interview'])->count())
                ->description(__('Applications in progress'))
                ->icon('heroicon-m-arrow-path')
                ->color('success'),

            Stat::make(__('Companies'), Company::count())
                ->description(__('Companies you applied to'))
                ->icon('heroicon-m-building-office')
                ->color('info'),
        ];
    }
}
