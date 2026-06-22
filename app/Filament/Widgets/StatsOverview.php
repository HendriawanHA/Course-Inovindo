<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Event;
use App\Models\Lesson;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\On;

class StatsOverview extends BaseWidget
{
    protected int|string|array $columnSpan = 3;
    protected static ?int $sort = 4;

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
            Stat::make('Courses', $this->countByPeriod(Course::query()))
                ->description($label)
                ->color('primary'),

            Stat::make('Lessons', $this->countByPeriod(Lesson::query()))
                ->description($label)
                ->color('success'),

            Stat::make('Students', $this->countByPeriod(User::where('role', 'student')))
                ->description($label)
                ->color('warning'),

            Stat::make('Events', $this->countByPeriod(Event::query()))
                ->description($label)
                ->color('danger'),
        ];
    }

    private function countByPeriod($query): int
    {
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
            'today' => 'Dibuat hari ini',
            '7' => '7 hari terakhir',
            '30' => '30 hari terakhir',
            '90' => '90 hari terakhir',
            default => 'Total',
        };
    }
}
