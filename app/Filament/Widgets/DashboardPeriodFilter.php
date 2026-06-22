<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardPeriodFilter extends Widget
{
    protected string $view = 'filament.widgets.dashboard-period-filter';

    protected int|string|array $columnSpan = 'full';

    public ?string $period = 'all';

    public function updatedPeriod(): void
    {
        $this->dispatch('period-changed', period: $this->period);
    }
}
