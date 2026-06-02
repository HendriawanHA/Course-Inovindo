<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Event;
use App\Models\Lesson;
use App\Models\User;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected int|string|array $columnSpan = 3;
    protected static ?int $sort = 4;

    protected function getStats(): array
    {
        return [

            Stat::make('Courses', Course::count())
                ->description('Total courses')
                ->color('primary'),

            Stat::make('Lessons', Lesson::count())
                ->description('Total lessons')
                ->color('success'),

            Stat::make(
                'Students',
                User::where('role', 'student')->count()
            )
                ->description('Registered students')
                ->color('warning'),

            Stat::make('Events', Event::count())
                ->description('Total events')
                ->color('danger'),

        ];
    }
}
