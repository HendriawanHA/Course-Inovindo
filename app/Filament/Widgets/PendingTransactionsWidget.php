<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\On;

class PendingTransactionsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 3;

    public ?string $period = 'all';

    #[On('period-changed')]
    public function onPeriodChanged(string $period): void
    {
        $this->period = $period;
    }

    protected function getStats(): array
    {
        $label = $this->periodLabel();

        return [
            Stat::make('Pending', $this->transactionCount('pending'))
                ->description($label)
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Paid', $this->transactionCount('paid'))
                ->description($label)
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Cancelled', $this->transactionCount('cancelled'))
                ->description($label)
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }

    private function transactionCount(string $status): int
    {
        $query = Transaction::where('status', $status);

        return match ($this->period) {
            'today' => $query->whereDate('created_at', today())->count(),
            '7' => $query->where('created_at', '>=', now()->subDays(7))->count(),
            '30' => $query->where('created_at', '>=', now()->subDays(30))->count(),
            '90' => $query->where('created_at', '>=', now()->subDays(90))->count(),
            default => $query->count(),
        };
    }

    private function periodLabel(): string
    {
        return match ($this->period) {
            'today' => 'Hari ini',
            '7' => '7 hari terakhir',
            '30' => '30 hari terakhir',
            '90' => '90 hari terakhir',
            default => 'Semua waktu',
        };
    }
}
