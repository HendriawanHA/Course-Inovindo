<div class="hidden md:flex items-center gap-2 mb-8">
    <a href="{{ route('events.index', ['filter' => 'all']) }}" wire:navigate>
        <flux:button
            variant="{{ $filter === 'all' ? 'filled' : 'subtle' }}">
            All Events
        </flux:button>
    </a>

    <a href="{{ route('events.index', ['filter' => 'upcoming']) }}" wire:navigate>
        <flux:button
            variant="{{ $filter === 'upcoming' ? 'filled' : 'subtle' }}">
            Upcoming
        </flux:button>
    </a>

    <a href="{{ route('events.index', ['filter' => 'past']) }}" wire:navigate>
        <flux:button
            variant="{{ $filter === 'past' ? 'filled' : 'subtle' }}">
            Past Events
        </flux:button>
    </a>
</div>

@php
$currentFilter = match($filter) {
'upcoming' => 'Upcoming',
'past' => 'Past Events',
default => 'All Events',
};
@endphp

<div class="flex justify-between items-center">
    <flux:heading size="xl" class="md:hidden mb-4 text-zinc-900 dark:text-white !font-bold">
        New Event
    </flux:heading>
    <flux:dropdown class="md:hidden mb-4">
        <flux:button icon:trailing="chevron-down">
            <div class="flex items-center gap-2">
                <flux:icon.funnel variant="mini" />
                <span>{{ $currentFilter }}</span>
            </div>
        </flux:button>

        <flux:menu>
            <flux:menu.item
                href="{{ route('events.index',['filter'=>'all']) }}"
                wire:navigate>
                All Events
            </flux:menu.item>

            <flux:menu.item
                href="{{ route('events.index',['filter'=>'upcoming']) }}"
                wire:navigate>
                Upcoming
            </flux:menu.item>

            <flux:menu.item
                href="{{ route('events.index',['filter'=>'past']) }}"
                wire:navigate>
                Past Events
            </flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</div>