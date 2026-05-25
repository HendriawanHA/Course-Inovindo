<flux:header class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 px-6 py-3 z-20">
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-2 cursor-pointer group">
            <img src="{{ asset('images/logo-transparan.webp') }}" class="w-32 h-12 object-contain" />

            <button type="button" @click="sidebarOpen = !sidebarOpen"
                class="p-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors">
                <flux:icon.chevron-down variant="micro" class="text-zinc-400 transition-transform"
                    ::class="sidebarOpen ? '' : '-rotate-90'" />
            </button>
        </div>
    </div>

    <flux:spacer />

    <!-- Main Navigation -->
    <flux:navbar class="-mb-px">
        <flux:navbar.item href="{{ route('home') }}" icon="home" wire:navigate>Home</flux:navbar.item>
        <flux:navbar.item href="{{ route('courses.index') }}" icon="book-open" wire:navigate>Courses</flux:navbar.item>
        <flux:navbar.item href="{{ route('events.index') }}" icon="calendar-days" wire:navigate>Events
        </flux:navbar.item>
        <flux:navbar.item href="{{ route('leaderboard.index') }}" icon="trophy" wire:navigate>Leaderboard
        </flux:navbar.item>
    </flux:navbar>

    <flux:spacer />

    <!-- Right Side Items -->
    <flux:navbar class="gap-2">
        <!-- Search -->
        <div class="relative max-lg:hidden">
            <form action="{{ route('courses.index') }}" method="GET">
                <flux:input name="search" value="{{ request('search') }}" variant="filled"
                    placeholder="Search courses..." icon="magnifying-glass"
                    class="bg-zinc-100 dark:bg-zinc-900 text-zinc-900 dark:text-white w-56" />
            </form>
        </div>

        <!-- Notification -->
        <div x-data="{ open: false }" class="relative">

            <!-- NOTIFICATION BUTTON -->
            <div class="relative">

                <flux:navbar.item icon="bell" @click="open = !open" class="cursor-pointer" />

                <!-- NOTIFICATION DOT -->
                <span
                    class="absolute top-1 right-3.5
            block h-2 w-2 rounded-full
            bg-red-500
            ring-2 ring-white dark:ring-zinc-950">
                </span>

            </div>

            <!-- OVERLAY -->
            <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 z-40">
            </div>

            <!-- POPOVER -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 scale-95" @click.away="open = false"
                class="absolute right-0 mt-4 w-[380px] z-50">

                <!-- ARROW -->
                <div
                    class="absolute -top-2 right-6 w-4 h-4 rotate-45
            bg-white dark:bg-zinc-900
            border-l border-t
            border-zinc-200 dark:border-zinc-800">
                </div>

                <!-- PANEL -->
                <div
                    class="relative overflow-hidden rounded-3xl
            border border-zinc-200 dark:border-zinc-800
            bg-white/90 dark:bg-zinc-900/90
            backdrop-blur-2xl
            shadow-2xl">

                    <!-- HEADER -->
                    <div
                        class="flex items-center justify-between
                px-6 py-5 border-b border-zinc-200 dark:border-zinc-800">

                        <div>

                            <h2 class="font-semibold text-zinc-900 dark:text-white">
                                Notifications
                            </h2>

                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                Latest updates and activity.
                            </p>

                        </div>

                        <flux:button size="sm" variant="ghost" icon="x-mark" @click="open = false" />

                    </div>

                    <!-- CONTENT -->
                    <div class="max-h-[400px] overflow-y-auto">

                        <!-- EMPTY STATE -->
                        {{--
                tampilkan ini jika notifikasi kosong
                --}}
                        <div
                            class="flex flex-col items-center justify-center
                    text-center px-8 py-14">

                            <div
                                class="w-16 h-16 rounded-2xl
                        bg-indigo-500/10
                        flex items-center justify-center mb-5">

                                <flux:icon.bell class="w-8 h-8 text-indigo-500" />

                            </div>

                            <h3 class="font-semibold text-zinc-900 dark:text-white">
                                No notifications
                            </h3>

                            <p
                                class="mt-2 text-sm leading-relaxed
                        text-zinc-500 dark:text-zinc-400 max-w-xs">

                                You don’t have any notifications yet.

                            </p>

                        </div>

                        <!-- NOTIFICATION ITEM -->
                        {{--
                contoh item notifikasi
                nanti tinggal loop database
                --}}
                        {{--
                <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800
                    hover:bg-zinc-50 dark:hover:bg-zinc-800/50
                    transition-colors cursor-pointer">

                    <div class="flex items-start gap-4">

                        <div class="w-10 h-10 rounded-2xl
                            bg-indigo-500/10
                            flex items-center justify-center shrink-0">

                            <flux:icon.academic-cap
                                class="w-5 h-5 text-indigo-500" />

                        </div>

                        <div class="flex-1">

                            <div class="flex items-center justify-between gap-3">

                                <h4 class="font-medium text-sm text-zinc-900 dark:text-white">
                                    New lesson available
                                </h4>

                                <span class="text-xs text-zinc-400">
                                    2m ago
                                </span>

                            </div>

                            <p class="mt-1 text-sm leading-relaxed
                                text-zinc-500 dark:text-zinc-400">

                                Laravel Authentication Basics
                                has been updated with new content.

                            </p>

                        </div>

                    </div>

                </div>
                --}}

                    </div>

                    <!-- FOOTER -->
                    <div class="px-5 py-4 border-t border-zinc-200 dark:border-zinc-800">

                        <flux:button variant="ghost" class="w-full justify-center">

                            View All Notifications

                        </flux:button>

                    </div>

                </div>

            </div>

        </div>

        <div x-data="{ open: false }" class="relative">

            <!-- BUTTON -->
            <flux:navbar.item @click="open = !open" class="relative cursor-pointer">

                <flux:icon.chat-bubble-left-right class="w-5 h-5" />

                <!-- Notification Dot -->
                <div class="absolute top-1 right-2.5 w-2 h-2 rounded-full bg-indigo-500"></div>

            </flux:navbar.item>

            <!-- Overlay -->
            <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 z-40">
            </div>

            <!-- COMMENT PANEL -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 scale-95" @click.away="open = false"
                class="absolute right-0 mt-4 w-[380px] z-50">

                <!-- Arrow -->
                <div
                    class="absolute -top-2 right-6 w-4 h-4 rotate-45
                                bg-white dark:bg-zinc-900
                                border-l border-t
                                border-zinc-200 dark:border-zinc-800">
                </div>

                <!-- Panel -->
                <div
                    class="relative overflow-hidden rounded-3xl
                                border border-zinc-200 dark:border-zinc-800
                                bg-white/90 dark:bg-zinc-900/90
                                backdrop-blur-2xl
                                shadow-2xl">

                    <!-- Header -->
                    <div
                        class="flex items-center justify-between
                                    px-6 py-5 border-b border-zinc-200 dark:border-zinc-800">

                        <div>

                            <h2 class="font-semibold text-zinc-900 dark:text-white">
                                Discussion
                            </h2>

                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                Share thoughts and ask questions.
                            </p>

                        </div>

                        <flux:button size="sm" variant="ghost" icon="x-mark" @click="open = false" />

                    </div>

                    <!-- Empty State -->
                    <div
                        class="flex flex-col items-center justify-center
                                    text-center px-8 py-14">

                        <div
                            class="w-16 h-16 rounded-2xl
                                        bg-indigo-500/10
                                        flex items-center justify-center mb-5">

                            <flux:icon.chat-bubble-left-right class="w-8 h-8 text-indigo-500" />

                        </div>

                        <h3 class="font-semibold text-zinc-900 dark:text-white">
                            No discussions yet
                        </h3>

                        <p
                            class="mt-2 text-sm leading-relaxed
                                        text-zinc-500 dark:text-zinc-400 max-w-xs">

                            Start the first discussion,
                            ask a question,
                            or share your thoughts.

                        </p>

                    </div>

                    <!-- Input -->
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">

                        <div class="flex items-end gap-3">

                            <flux:textarea rows="1" placeholder="Write a comment..."
                                class="flex-1 resize-none" />

                            <flux:button variant="primary" color="indigo">

                                Send

                            </flux:button>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <div x-data="{ open: false }" class="relative">

            <!-- FRIEND BUTTON -->
            <flux:navbar.item icon="user-group" @click="open = !open" class="cursor-pointer" />

            <!-- ONLINE DOT -->
            <span
                class="absolute top-1 right-3.5
        block h-2 w-2 rounded-full
        bg-emerald-500
        ring-2 ring-white dark:ring-zinc-950">
            </span>

            <!-- OVERLAY -->
            <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 z-40">
            </div>

            <!-- POPOVER -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 scale-95" @click.away="open = false"
                class="absolute right-0 mt-4 w-[380px] z-50">

                <!-- ARROW -->
                <div
                    class="absolute -top-2 right-6 w-4 h-4 rotate-45
            bg-white dark:bg-zinc-900
            border-l border-t
            border-zinc-200 dark:border-zinc-800">
                </div>

                <!-- PANEL -->
                <div
                    class="relative overflow-hidden rounded-3xl
            border border-zinc-200 dark:border-zinc-800
            bg-white/90 dark:bg-zinc-900/90
            backdrop-blur-2xl
            shadow-2xl">

                    <!-- HEADER -->
                    <div
                        class="flex items-center justify-between
                px-6 py-5 border-b border-zinc-200 dark:border-zinc-800">

                        <div>

                            <h2 class="font-semibold text-zinc-900 dark:text-white">
                                Friends
                            </h2>

                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                See your learning companions.
                            </p>

                        </div>

                        <flux:button size="sm" variant="ghost" icon="x-mark" @click="open = false" />

                    </div>

                    <!-- SEARCH -->
                    <div class="p-4 border-b border-zinc-200 dark:border-zinc-800">

                        <flux:input icon="magnifying-glass" placeholder="Search friends..." />

                    </div>

                    <!-- FRIEND LIST -->
                    <div class="max-h-[420px] overflow-y-auto">

                        <!-- EMPTY STATE -->
                        {{--
                tampilkan jika belum ada teman
                --}}
                        {{--
                <div class="flex flex-col items-center justify-center
                    text-center px-8 py-14">

                    <div class="w-16 h-16 rounded-2xl
                        bg-indigo-500/10
                        flex items-center justify-center mb-5">

                        <flux:icon.user-group
                            class="w-8 h-8 text-indigo-500" />

                    </div>

                    <h3 class="font-semibold text-zinc-900 dark:text-white">
                        No friends yet
                    </h3>

                    <p class="mt-2 text-sm leading-relaxed
                        text-zinc-500 dark:text-zinc-400 max-w-xs">

                        Start connecting with other learners
                        and build your study network.

                    </p>

                </div>
                --}}

                        <!-- FRIEND ITEM -->
                        {{--
                nanti tinggal loop database
                --}}
                        <div
                            class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-800
                    hover:bg-zinc-50 dark:hover:bg-zinc-800/50
                    transition-colors cursor-pointer">

                            <div class="flex items-center gap-4">

                                <!-- AVATAR -->
                                <div class="relative shrink-0">

                                    <flux:avatar circle size="md"
                                        src="https://ui-avatars.com/api/?name=Hendri" />

                                    <!-- ONLINE STATUS -->
                                    <div
                                        class="absolute bottom-0 right-0
                                w-3 h-3 rounded-full
                                bg-emerald-500
                                border-2 border-white dark:border-zinc-900">
                                    </div>

                                </div>

                                <!-- INFO -->
                                <div class="flex-1 min-w-0">

                                    <div class="flex items-center justify-between gap-3">

                                        <h4
                                            class="font-medium text-sm truncate
                                    text-zinc-900 dark:text-white">

                                            Hendriawan

                                        </h4>

                                        <span class="text-xs text-emerald-500">
                                            Online
                                        </span>

                                    </div>

                                    <p
                                        class="mt-1 text-sm truncate
                                text-zinc-500 dark:text-zinc-400">

                                        Currently learning Laravel Basics

                                    </p>

                                </div>

                            </div>

                        </div>

                        <!-- FRIEND ITEM -->
                        <div
                            class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-800
                    hover:bg-zinc-50 dark:hover:bg-zinc-800/50
                    transition-colors cursor-pointer">

                            <div class="flex items-center gap-4">

                                <div class="relative shrink-0">

                                    <flux:avatar circle size="md" src="https://ui-avatars.com/api/?name=Adi" />

                                    <!-- OFFLINE -->
                                    <div
                                        class="absolute bottom-0 right-0
                                w-3 h-3 rounded-full
                                bg-zinc-400
                                border-2 border-white dark:border-zinc-900">
                                    </div>

                                </div>

                                <div class="flex-1 min-w-0">

                                    <div class="flex items-center justify-between gap-3">

                                        <h4
                                            class="font-medium text-sm truncate
                                    text-zinc-900 dark:text-white">

                                            Adi Mulyadi

                                        </h4>

                                        <span class="text-xs text-zinc-400">
                                            Offline
                                        </span>

                                    </div>

                                    <p
                                        class="mt-1 text-sm truncate
                                text-zinc-500 dark:text-zinc-400">

                                        Last active 2 hours ago

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="px-5 py-4 border-t border-zinc-200 dark:border-zinc-800">

                        <flux:button variant="ghost" class="w-full justify-center">

                            View All Friends

                        </flux:button>

                    </div>

                </div>

            </div>

        </div>

        <flux:navbar.item
            icon="bookmark"
            href="{{ route('courses.saved') }}"
            wire:navigate />
        <!-- Profile Dropdown -->
        <flux:dropdown position="top" align="end">
            @auth

                <flux:profile circle :chevron="false"
                    avatar="{{ auth()->user()->avatar
                        ? asset('storage/' . auth()->user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" />

            @endauth

            <flux:menu>
                <div class="flex justify-between items-center">
                    <a href="{{ route('profile') }}">
                        <flux:menu.item icon="user-circle">My Profile</flux:menu.item>
                    </a>

                    <!-- Theme Switcher -->
                    <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" variant="subtle"
                        aria-label="Toggle dark mode" class="hover:bg-zinc-100 dark:hover:bg-zinc-800">

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
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                        Logout
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:navbar>
</flux:header>
