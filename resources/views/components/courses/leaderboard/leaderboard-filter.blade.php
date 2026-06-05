<div class="hidden md:flex gap-2">
    <a
        href="{{ route('leaderboard.index',['filter'=>'7days']) }}"
        wire:navigate>

        <flux:button
            variant="{{ $filter === '7days' ? 'filled' : 'ghost' }}"
            class="rounded-full">

            7 Days

        </flux:button>

    </a>

    <a
        href="{{ route('leaderboard.index',['filter'=>'30days']) }}"
        wire:navigate>

        <flux:button
            variant="{{ $filter === '30days' ? 'filled' : 'ghost' }}"
            class="rounded-full">

            30 Days

        </flux:button>

    </a>

    <a
        href="{{ route('leaderboard.index',['filter'=>'all']) }}"
        wire:navigate>

        <flux:button
            variant="{{ $filter === 'all' ? 'filled' : 'ghost' }}"
            class="rounded-full">

            All Time

        </flux:button>

    </a>

</div>

<flux:dropdown class="md:hidden">
    @php
    $currentFilter = match($filter) {
    '7days' => '7 Days',
    '30days' => '30 Days',
    default => 'All Time',
    };
    @endphp
    <flux:button icon:trailing="chevron-down">
        <div class="flex items-center gap-2">
            <flux:icon.funnel variant="mini" />
            <span>{{ $currentFilter }}</span>
        </div>
    </flux:button>

    <flux:menu>
        <flux:menu.item
            href="{{ route('leaderboard.index',['filter'=>'7days']) }}"
            wire:navigate>
            7 Days
        </flux:menu.item>

        <flux:menu.item
            href="{{ route('leaderboard.index',['filter'=>'30days']) }}"
            wire:navigate>
            30 Days
        </flux:menu.item>

        <flux:menu.item
            href="{{ route('leaderboard.index',['filter'=>'all']) }}"
            wire:navigate>
            All Time
        </flux:menu.item>
    </flux:menu>
</flux:dropdown>