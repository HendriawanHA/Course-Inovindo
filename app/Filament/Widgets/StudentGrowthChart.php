<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class StudentGrowthChart extends ChartWidget
{
    protected ?string $heading = 'Student Growth';
    protected ?string $maxHeight = '300px';
    protected int|string|array $columnSpan = 3;
    protected static ?int $sort = 3;

    public ?string $filter = '12';

    protected function getFilters(): ?array
    {
        return [
            '3' => '3 bulan',
            '6' => '6 bulan',
            '12' => '12 bulan',
        ];
    }

    protected function getData(): array
    {
        $total = (int) ($this->filter ?: 12);
        $labels = [];
        $students = [];

        for ($i = $total - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M Y');

            $students[] = User::where('role', 'student')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Students',
                    'data' => $students,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
