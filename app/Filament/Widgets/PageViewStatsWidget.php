<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\On;

class PageViewStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 3;

    public ?string $period = 'all';

    #[On('period-changed')]
    public function onPeriodChanged(string $period): void
    {
        $this->period = $period;
    }

    protected function getStats(): array
    {
        $query = PageView::query();
        $query = $this->applyPeriodFilter($query);

        $uniqueVisitorsQuery = PageView::query();
        $uniqueVisitorsQuery = $this->applyPeriodFilter($uniqueVisitorsQuery);

        $urlQuery = PageView::query();
        $urlQuery = $this->applyPeriodFilter($urlQuery);

        return [
            Stat::make('Views', $query->count())
                ->description($this->periodLabel())
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),

            Stat::make('Unique Visitors', $uniqueVisitorsQuery->distinct('ip_address')->count('ip_address'))
                ->description($this->periodLabel())
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),

            Stat::make('Pages Visited', $urlQuery->distinct('url')->count('url'))
                ->description($this->periodLabel())
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('success'),
        ];
    }

    private function applyPeriodFilter($query)
    {
        return match ($this->period) {
            'today' => $query->whereDate('created_at', today()),
            '7' => $query->where('created_at', '>=', now()->subDays(7)),
            '30' => $query->where('created_at', '>=', now()->subDays(30)),
            '90' => $query->where('created_at', '>=', now()->subDays(90)),
            default => $query,
        };
    }

    private function periodLabel(): string
    {
        return match ($this->period) {
            'today' => 'Hari ini',
            '7' => '7 hari terakhir',
            '30' => '30 hari terakhir',
            '90' => '90 hari terakhir',
            default => 'Kunjungan website',
        };
    }
}
