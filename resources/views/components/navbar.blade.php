<flux:header class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 px-3 md:px-6 py-3 z-20">
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-2 cursor-pointer group">
            <img src="{{ asset('images/logo-transparan.webp') }}" class="w-24 md:w-32 h-auto object-contain" />
            <button type="button" @click="sidebarOpen = !sidebarOpen"
                class="p-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-colors">
                <flux:icon.chevron-down variant="micro" class="text-zinc-400 transition-transform"
                    ::class="sidebarOpen ? '' : '-rotate-90'" />
            </button>
        </div>
    </div>

    <flux:spacer />

    <!-- Main Navigation -->
    <div class="hidden lg:block">
        <x-courses.navbar.main-nav />
    </div>

    <flux:spacer />

    <!-- Right Side Items -->
    <flux:navbar class="gap-2">
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
        <!-- Search -->
        @if($showSearch)
        <div class="relative hidden xl:block">
            <form action="{{ $searchRoute }}" method="GET">
                @if(request()->routeIs('events.index'))
                <input
                    type="hidden"
                    name="filter"
                    value="{{ request('filter', 'all') }}">
                @endif
                <flux:input
                    name="search"
                    value="{{ request('search') }}"
                    variant="filled"
                    placeholder="{{ $searchPlaceholder }}"
                    icon="magnifying-glass"
                    class="bg-zinc-100 dark:bg-zinc-900 text-zinc-900 dark:text-white w-56" />
            </form>
        </div>
        @endif

        @php
        $notifications = auth()
        ->user()
        ->unreadNotifications()
        ->latest()
        ->take(10)
        ->get();
        @endphp

        <!-- Notification -->
        <div x-data="{ open: false }" class="relative">
            <!-- NOTIFICATION BUTTON -->
            <div class="relative">
                <flux:navbar.item icon="bell" @click="open = !open" class="cursor-pointer" />
                <!-- NOTIFICATION DOT -->
                @php
                $unreadCount = auth()->user()->unreadNotifications()->count();
                @endphp
                @if($unreadCount)
                <span
                    class="absolute -top-1 right-1 min-w-[18px] h-[18px] px-1 flex items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-bold">
                    {{ $unreadCount }}
                </span>
                @endif
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
                class="fixed top-20 right-2 left-2 z-50 md:absolute md:left-auto md:right-0 md:w-[380px]">
                <!-- ARROW -->
                <div
                    class="hidden sm:block absolute -top-2 right-6 w-4 h-4 rotate-45 bg-white dark:bg-zinc-900 border-l border-t border-zinc-200 dark:border-zinc-800">
                </div>
                <!-- PANEL -->
                <div class="relative overflow-hidden rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-2xl shadow-2xl">
                    <!-- HEADER -->
                    <div class="flex items-center justify-between px-4 py-4 md:px-6 md:py-5 border-b border-zinc-200 dark:border-zinc-800">
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
                        @if($notifications->isEmpty())
                        <!-- EMPTY STATE -->
                        <div class="flex flex-col items-center justify-center text-center px-8 py-14">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 flex items-center justify-center mb-5">
                                <flux:icon.bell class="w-8 h-8 text-indigo-500" />
                            </div>
                            <h3 class="font-semibold text-zinc-900 dark:text-white">
                                No notifications
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-zinc-500 dark:text-zinc-400 max-w-xs">
                                You don’t have any notifications yet.
                            </p>
                        </div>
                        @else

                        @foreach($notifications as $notification)
                        <a
                            href="{{ route('notifications.read', $notification->id) }}"
                            class="block">
                            <div
                                class="px-4 py-4 md:px-6 md:py-5 border-b border-zinc-200 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors cursor-pointer">
                                <div class="flex items-start gap-4">
                                    <div class="shrink-0">
                                        @if(!empty($notification->data['thumbnail']))
                                        <img
                                            src="{{ asset('storage/' . $notification->data['thumbnail']) }}"
                                            class="w-12 h-12 rounded-xl object-cover">
                                        @else
                                        <div
                                            class="w-10 h-10 rounded-2xl bg-indigo-500/10 flex items-center justify-center">
                                            @if(($notification->data['type'] ?? '') === 'course')
                                            <flux:icon.academic-cap
                                                class="w-5 h-5 text-indigo-500" />
                                            @elseif(($notification->data['type'] ?? '') === 'event')
                                            <flux:icon.calendar-days
                                                class="w-5 h-5 text-emerald-500" />
                                            @elseif(($notification->data['type'] ?? '') === 'discussion_reply')
                                            <flux:icon.chat-bubble-left-right
                                                class="w-5 h-5 text-orange-500" />
                                            @else
                                            <flux:icon.bell
                                                class="w-5 h-5 text-zinc-500" />
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between gap-3">
                                            <h4
                                                class="font-medium text-sm text-zinc-900 dark:text-white">
                                                {{ $notification->data['title'] }}
                                            </h4>
                                            <span class="text-xs text-zinc-400">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p
                                            class="mt-1 text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">
                                            {{ $notification->data['message'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                        @endif

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

        <div x-data="{ open: false }" class="relative hidden lg:block">
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
                <div class="absolute -top-2 right-6 w-4 h-4 rotate-45
                                bg-white dark:bg-zinc-900
                                border-l border-t
                                border-zinc-200 dark:border-zinc-800">
                </div>
                <!-- Panel -->
                <div class="relative overflow-hidden rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-2xl shadow-2xl">
                    <!-- Header -->
                    <div class="flex items-center justify-between px-6 py-5 border-b border-zinc-200 dark:border-zinc-800">
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
                    <div class="flex flex-col items-center justify-center text-center px-8 py-14">
                        <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 flex items-center justify-center mb-5">
                            <flux:icon.chat-bubble-left-right class="w-8 h-8 text-indigo-500" />
                        </div>
                        <h3 class="font-semibold text-zinc-900 dark:text-white">
                            No discussions yet
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-zinc-500 dark:text-zinc-400 max-w-xs">
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

        <div x-data="{ open: false }" class="relative hidden lg:block">
            <!-- FRIEND BUTTON -->
            <flux:navbar.item icon="user-group" @click="open = !open" class="cursor-pointer" />
            <!-- ONLINE DOT -->
            <span class="absolute top-1 right-3.5 block h-2 w-2 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-zinc-950">
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
                <div class="absolute -top-2 right-6 w-4 h-4 rotate-45 bg-white dark:bg-zinc-900 border-l border-t border-zinc-200 dark:border-zinc-800">
                </div>
                <!-- PANEL -->
                <div class="relative overflow-hidden rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-2xl shadow-2xl">
                    <!-- HEADER -->
                    <div class="flex items-center justify-between px-6 py-5 border-b border-zinc-200 dark:border-zinc-800">
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
                        <!-- FRIEND ITEM -->
                        <div class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-8 hover:bg-zinc-50 dark:hover:bg-zinc-800/ transition-colors cursor-pointer">
                            <div class="flex items-center gap-4">
                                <!-- AVATAR -->
                                <div class="relative shrink-0">
                                    <flux:avatar circle size="md"
                                        src="https://ui-avatars.com/api/?name=Hendri" />
                                    <!-- ONLINE STATUS -->
                                    <div class="absolute bottom-0 right w-3 h-3 rounded-fu bg-emerald-5 border-2 border-white dark:border-zinc-900">
                                    </div>
                                </div>
                                <!-- INFO -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-3">
                                        <h4 class="font-medium text-sm trunca text-zinc-900 dark:text-white">
                                            Hendriawan
                                        </h4>
                                        <span class="text-xs text-emerald-500">
                                            Online
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm trunca text-zinc-500 dark:text-zinc-400">
                                        Currently learning Laravel Basics
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- FRIEND ITEM -->
                        <div class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-8 hover:bg-zinc-50 dark:hover:bg-zinc-800/ transition-colors cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="relative shrink-0">
                                    <flux:avatar circle size="md" src="https://ui-avatars.com/api/?name=Adi" />
                                    <!-- OFFLINE -->
                                    <div class="absolute bottom-0 right w-3 h-3 rounded-fu bg-zinc-4 border-2 border-white dark:border-zinc-900">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-3">
                                        <h4 class="font-medium text-sm trunca text-zinc-900 dark:text-white">
                                            Adi Mulyadi
                                        </h4>
                                        <span class="text-xs text-zinc-400">
                                            Offline
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm trunca text-zinc-500 dark:text-zinc-400">
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
                    <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" variant="subtle"
                        aria-label="Toggle dark mode" class="hover:bg-zinc-100 dark:hover:bg-zinc-800">
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