<flux:navbar class="-mb-px">
    <flux:navbar.item href="{{ route('home') }}" icon="home" wire:navigate>Home</flux:navbar.item>
    <flux:navbar.item href="{{ route('courses.index') }}" icon="book-open" wire:navigate>Courses</flux:navbar.item>
    <flux:navbar.item href="{{ route('events.index') }}" icon="calendar-days" wire:navigate>Events
    </flux:navbar.item>
    <flux:navbar.item href="{{ route('leaderboard.index') }}" icon="trophy" wire:navigate>Leaderboard
    </flux:navbar.item>
</flux:navbar>