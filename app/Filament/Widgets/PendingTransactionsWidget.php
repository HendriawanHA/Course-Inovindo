<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PendingTransactionsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 3;
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Pending Transactions',
                Transaction::where('status', 'pending')->count()

            )
                ->description('Menunggu pembayaran')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make(
                'Paid Transactions',
                Transaction::where('status', 'paid')->count()
            )
                ->description('Pembayaran berhasil')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(
                'Cancelled Transactions',
                Transaction::where('status', 'cancelled')->count()
            )
                ->description('Transaksi dibatalkan')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
