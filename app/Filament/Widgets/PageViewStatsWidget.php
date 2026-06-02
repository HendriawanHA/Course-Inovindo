<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PageViewStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 3;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Views', PageView::count())
                ->description('Total kunjungan website')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),

            Stat::make('Views Today', PageView::whereDate('created_at', today())->count())
                ->description('Kunjungan hari ini')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),

            Stat::make('Unique Visitors', PageView::distinct('ip_address')->count('ip_address'))
                ->description('Berdasarkan alamat IP')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
