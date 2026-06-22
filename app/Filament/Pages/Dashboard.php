<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardPeriodFilter;
use App\Filament\Widgets\PageViewStatsWidget;
use App\Filament\Widgets\PendingTransactionsWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\StudentGrowthChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            DashboardPeriodFilter::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            PendingTransactionsWidget::class,
            PageViewStatsWidget::class,
            StudentGrowthChart::class,
            StatsOverview::class,
        ];
    }
}
