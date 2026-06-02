<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class StudentGrowthChart extends ChartWidget
{
    protected ?string $heading = 'Student Growth';
    protected  ?string $maxHeight = '300px';
    protected int|string|array $columnSpan = 2;
    protected static ?int $sort = 4;


    protected function getData(): array
    {
        $months = [];
        $students = [];

        // 12 bulan terakhir
        for ($i = 11; $i >= 0; $i--) {

            $date = now()->subMonths($i);

            $months[] = $date->format('M');

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

            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
