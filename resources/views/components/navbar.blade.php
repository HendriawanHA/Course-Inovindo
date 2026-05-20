<flux:header class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 px-6 py-3 z-20">
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-2 cursor-pointer group">
            <img
                src="{{ asset('storage/images/logo-transparan.webp') }}"
                class="w-32 h-12 object-contain" />

            <button
                type="button"
                @click="sidebarOpen = !sidebarOpen"
                class="p-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors">
                <flux:icon.chevron-down
                    variant="micro"
                    class="text-zinc-400 transition-transform"
                    ::class="sidebarOpen ? '' : '-rotate-90'" />
            </button>
        </div>
    </div>

    <flux:spacer />

    <!-- Main Navigation -->
    <flux:navbar class="-mb-px">
        <flux:navbar.item href="{{ route('home') }}" icon="home" wire:navigate>Home</flux:navbar.item>
        <flux:navbar.item href="{{ route('courses.index') }}" icon="book-open" wire:navigate>Courses</flux:navbar.item>
        <flux:navbar.item href="{{ route('events.index') }}" icon="calendar-days" wire:navigate>Events</flux:navbar.item>
        <flux:navbar.item href="{{ route('leaderboard.index') }}" icon="trophy" wire:navigate>Leaderboard</flux:navbar.item>
    </flux:navbar>

    <flux:spacer />

    <!-- Right Side Items -->
    <flux:navbar class="gap-2">
        <!-- Search -->
        <div class="relative max-lg:hidden">
            <form action="{{ route('courses.index') }}" method="GET">
                <flux:input
                    name="search"
                    value="{{ request('search') }}"
                    variant="filled"
                    placeholder="Search courses..."
                    icon="magnifying-glass"
                    class="bg-zinc-100 dark:bg-zinc-900 text-zinc-900 dark:text-white w-56" />
            </form>
        </div>

        <!-- Notification -->
        <div class="relative inline-block">
            <flux:navbar.item icon="bell" href="#" />
            <span class="absolute top-1 right-3.5 block h-1.5 w-1.5 rounded-full bg-red-500 ring-2 ring-white dark:ring-zinc-950"></span>
        </div>

        <flux:navbar.item icon="chat-bubble-left-right" href="#" />
        <flux:navbar.item icon="user-group" href="#" />
        <flux:navbar.item icon="bookmark" href="#" />

        <!-- Profile Dropdown -->
        <flux:dropdown position="top" align="end">
            <flux:profile
                circle :chevron="false"
                avatar="{{ auth()->user()->avatar
        ? asset('storage/' . auth()->user()->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" />

            <flux:menu>
                <div class="flex justify-between items-center">
                    <a href="{{ route('profile') }}">
                        <flux:menu.item icon="user-circle">My Profile</flux:menu.item>
                    </a>

                    <!-- Theme Switcher -->
                    <flux:button
                        x-data
                        x-on:click="$flux.dark = ! $flux.dark"
                        variant="subtle"
                        aria-label="Toggle dark mode"
                        class="hover:bg-zinc-100 dark:hover:bg-zinc-800">

                        <!-- Icon Dinamis -->
                        <span x-show="$flux.dark" class="transition-transform">
                            <flux:icon.sun variant="micro" />
                        </span>
                        <span x-show="!$flux.dark" class="transition-transform">
                            <flux:icon.moon variant="micro" />
                        </span>
                    </flux:button>
                </div>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item
                        as="button"
                        type="submit"
                        icon="arrow-right-start-on-rectangle">
                        Logout
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:navbar>
</flux:header>