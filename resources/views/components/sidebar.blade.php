<!-- Sidebar -->
<div
    x-show="sidebarOpen"
    x-transition.opacity
    class="fixed inset-0 bg-black/50 z-40 lg:hidden"
    @click="sidebarOpen = false">
</div>
<div x-show="sidebarOpen"
    class="fixed lg:relative
        inset-y-0 left-0
        z-50 lg:z-auto
        w-64
        bg-white dark:bg-zinc-900
        border-r border-zinc-200 dark:border-zinc-800
        flex flex-col flex-shrink-0
        overflow-hidden
        shadow-xl
        lg:shadow-none
        transition-all duration-300"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="-ml-64"
    x-transition:enter-end="ml-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="ml-0"
    x-transition:leave-end="-ml-64">

    <flux:sidebar sticky class="w-full h-full bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white border-none overflow-y-auto scroll-hide">

        @php
        $showSearch = false;
        $searchRoute = '';
        $searchPlaceholder = '';

        if (request()->routeIs('courses.index')) {
        $showSearch = true;
        $searchRoute = route('courses.index');
        $searchPlaceholder = 'Search courses...';
        } elseif (request()->routeIs('courses.saved')) {
        $showSearch = true;
        $searchRoute = route('courses.saved');
        $searchPlaceholder = 'Search saved courses...';
        } elseif (request()->routeIs('courses.my')) {
        $showSearch = true;
        $searchRoute = route('courses.my');
        $searchPlaceholder = 'Search my courses...';
        } elseif (request()->routeIs('events.index')) {
        $showSearch = true;
        $searchRoute = route('events.index');
        $searchPlaceholder = 'Search events...';
        }
        @endphp

        <flux:sidebar.nav class="px-3">
            @if($showSearch)
            <div class="lg:hidden px-3 mb-4">
                <form action="{{ $searchRoute }}" method="GET">
                    <flux:input
                        name="search"
                        value="{{ request('search') }}"
                        icon="magnifying-glass"
                        placeholder="{{ $searchPlaceholder }}" />
                </form>
            </div>
            @endif

            <flux:sidebar.group heading="MENU" class="mt-2 lg:hidden">
                <div class="space-y-2">
                    <flux:sidebar.item icon="home" href="{{ route('home') }}" @click="sidebarOpen = false" wire:navigate>Home</flux:sidebar.item>
                    <flux:sidebar.item icon="academic-cap" href="{{ route('courses.index') }}" @click="sidebarOpen = false" wire:navigate>Courses</flux:sidebar.item>
                    <flux:sidebar.item icon="calendar-days" href="{{ route('events.index') }}" @click="sidebarOpen = false" wire:navigate>Events</flux:sidebar.item>
                    <flux:sidebar.item icon="trophy" href="{{ route('leaderboard.index') }}" @click="sidebarOpen = false" wire:navigate>Leaderboard</flux:sidebar.item>
                </div>
            </flux:sidebar.group>

            <flux:sidebar.group heading="MY COURSES" class="mt-6 lg:mt-0">
                @forelse($myCourses as $enrollment)
                <flux:sidebar.item
                    href="{{ route('courses.show', $enrollment->course->id) }}"
                    icon="book-open"
                    class="mb-3">
                    <div class="flex flex-col">
                        <span>
                            {{ Str::limit($enrollment->course->title, 22) }}
                        </span>
                        @if($enrollment->status === 'completed')
                        <span class="text-xs text-green-600">
                            Completed
                        </span>
                        @else
                        <span class="text-xs text-zinc-500">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                        @endif
                    </div>
                </flux:sidebar.item>
                @empty
                <div class="text-sm text-zinc-500 px-2">
                    No enrolled course
                </div>
                @endforelse
            </flux:sidebar.group>
        </flux:sidebar.nav>
    </flux:sidebar>
</div>