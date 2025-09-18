<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use App\Models\Company;
use App\Models\HrContact;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApplicationStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Applications', Application::count())
                ->description('Total job applications')
                ->icon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Active Applications', Application::whereIn('status', ['applied', 'interview'])->count())
                ->description('Applications in progress')
                ->icon('heroicon-m-arrow-path')
                ->color('success'),

            Stat::make('Companies', Company::count())
                ->description('Companies you applied to')
                ->icon('heroicon-m-building-office')
                ->color('warning'),
        ];
    }
}
