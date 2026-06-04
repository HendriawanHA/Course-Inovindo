<div class="hidden md:flex gap-2">
    <flux:button variant="filled" class="rounded-full">7 days</flux:button>
    <flux:button variant="ghost" class="rounded-full">30 days</flux:button>
    <flux:button variant="ghost" class="rounded-full">All time</flux:button>
</div>

<flux:dropdown class="md:hidden">
    <flux:button icon:trailing="chevron-down">
        <div class="flex items-center gap-2">
            <flux:icon.funnel variant="mini" />
            <span>Filter</span>
        </div>
    </flux:button>

    <flux:menu>
        <flux:menu.item
            href="{{ route('leaderboard.index',['filter'=>'all']) }}"
            wire:navigate>
            7 Days
        </flux:menu.item>

        <flux:menu.item
            href="{{ route('leaderboard.index',['filter'=>'upcoming']) }}"
            wire:navigate>
            30 Days
        </flux:menu.item>

        <flux:menu.item
            href="{{ route('leaderboard.index',['filter'=>'past']) }}"
            wire:navigate>
            All time
        </flux:menu.item>
    </flux:menu>
</flux:dropdown>

<!-- // @php
// $currentFilter = match($filter) {
// '7days' => '7 Days',
// 'past' => '30 Days',
// default => 'All time',
// };
// @endphp -->