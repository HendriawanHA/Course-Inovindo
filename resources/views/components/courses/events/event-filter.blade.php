<div class="flex items-center gap-2 mb-8">

    <a href="{{ route('events.index', ['filter' => 'all']) }}">
        <flux:button
            variant="{{ $filter === 'all' ? 'filled' : 'subtle' }}">
            All Events
        </flux:button>
    </a>

    <a href="{{ route('events.index', ['filter' => 'upcoming']) }}">
        <flux:button
            variant="{{ $filter === 'upcoming' ? 'filled' : 'subtle' }}">
            Upcoming
        </flux:button>
    </a>

    <a href="{{ route('events.index', ['filter' => 'past']) }}">
        <flux:button
            variant="{{ $filter === 'past' ? 'filled' : 'subtle' }}">
            Past Events
        </flux:button>
    </a>

</div>