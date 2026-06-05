<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Instructor Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>

<body class="bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-950 dark:text-white">
    <div x-data="{ mobileMenuOpen: false }" class="min-h-screen lg:flex">

        <!-- Sidebar -->
        <aside class="sticky top-0 z-10 hidden h-screen w-72 flex-col border-r border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900 lg:flex">
            <div class="flex items-center gap-3 border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
                <img src="{{ asset('images/logo-transparan.webp') }}" alt="Inovindo" class="h-11 rounded-xl object-contain">
                <span class="text-md font-bold text-zinc-900 dark:text-white">Instructor</span>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto p-4 scroll-hide">

                <a href="{{ route('instructor.dashboard') }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('instructor.dashboard') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    <flux:icon.home class="size-5" />
                    Dashboard
                </a>

                {{-- MY COURSES --}}
                <div class="pt-2">
                    <a href="{{ route('instructor.courses.index') }}"
                        class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
                            {{ request()->routeIs('instructor.courses.index') || request()->routeIs('instructor.courses.create') || request()->routeIs('instructor.courses.edit') || request()->routeIs('instructor.courses.preview') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                        <flux:icon.book-open class="size-5" />
                        My Courses
                    </a>
                </div>

                <a href="{{ route('instructor.students.index') }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('instructor.students.*') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    <flux:icon.academic-cap class="size-5" />
                    Students
                </a>

                <div>
                    <a href="{{ route('instructor.discussions.index') }}"
                        class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
                            {{ request()->routeIs('instructor.discussions.*') || request()->routeIs('instructor.courses.discussions') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                        <flux:icon.chat-bubble-left-right class="size-5" />
                        <span class="flex-1">Discussions</span>
                        @if ($unreadDiscussions > 0)
                            <span class="flex h-5 min-w-[20px] items-center justify-center rounded-full bg-amber-500 px-1.5 text-[11px] font-bold text-white tabular-nums">{{ $unreadDiscussions }}</span>
                        @endif
                    </a>

                    @if ((request()->routeIs('instructor.discussions.*') || request()->routeIs('instructor.courses.discussions')) && $sidebarCourses->isNotEmpty())
                        <div class="ml-3 mt-1 space-y-0.5 border-l border-zinc-200 pl-3 dark:border-zinc-700">
                            @foreach ($sidebarCourses as $sc)
                                <a href="{{ route('instructor.courses.discussions', $sc) }}"
                                    class="flex items-center justify-between rounded-xl px-3 py-2 text-xs font-medium transition
                                        {{ request()->route('course')?->id === $sc->id ? 'bg-indigo-500/10 text-indigo-400' : 'text-zinc-500 hover:text-zinc-300' }}">
                                    <span class="truncate">{{ $sc->title }}</span>
                                    @if ($sc->discussions_count > 0)
                                        <span class="ml-2 flex-shrink-0 rounded-full bg-zinc-800 px-2 py-0.5 text-[11px] tabular-nums text-zinc-400">{{ $sc->discussions_count }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

            </nav>

            <div class="border-t border-zinc-200 p-4 dark:border-zinc-800">
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button type="button" @click="open = ! open"
                        class="group flex w-full items-center gap-3 rounded-2xl p-3 text-left transition hover:bg-zinc-100 dark:hover:bg-zinc-800">
                        <img
                            src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                            alt="{{ auth()->user()->name }}"
                            class="size-10 rounded-full object-cover ring-1 ring-zinc-200 dark:ring-zinc-700">
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-zinc-500 dark:text-zinc-400">{{ auth()->user()->email }}</p>
                        </div>
                        <flux:icon.chevron-up class="size-4 shrink-0 text-zinc-400 transition group-hover:text-zinc-600 dark:group-hover:text-zinc-300" ::class="open ? 'rotate-180' : ''" />
                    </button>

                    <div x-show="open" x-transition.origin.bottom class="absolute bottom-full left-0 right-0 mb-2 overflow-hidden rounded-2xl border border-zinc-200 bg-white p-2 shadow-xl dark:border-zinc-800 dark:bg-zinc-900">
                        <a href="{{ route('instructor.profile') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white">
                            <flux:icon.user-circle class="size-5" />
                            Profile
                        </a>

                        <button type="button" x-data x-on:click="$flux.dark = ! $flux.dark"
                            class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white"
                            aria-label="Toggle dark mode">
                            <span x-show="$flux.dark" class="inline-flex items-center gap-3">
                                <flux:icon.sun class="size-5" />
                                Light Mode
                            </span>
                            <span x-show="! $flux.dark" class="inline-flex items-center gap-3">
                                <flux:icon.moon class="size-5" />
                                Dark Mode
                            </span>
                        </button>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-zinc-600 transition hover:bg-red-50 hover:text-red-600 dark:text-zinc-300 dark:hover:bg-red-500/10 dark:hover:text-red-400">
                                <flux:icon.arrow-right-start-on-rectangle class="size-5" />
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex min-w-0 flex-1 flex-col p-4 sm:p-6">
            <header class="mb-5 rounded-3xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900 lg:hidden">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-transparan.webp') }}" alt="Inovindo" class="h-11 w-11 rounded-xl object-contain">
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">Instructor</span>
                    </div>
                    <button type="button"
                        @click="mobileMenuOpen = true"
                        class="rounded-2xl border border-zinc-200 p-2.5 text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-800"
                        aria-label="Open instructor menu">
                        <flux:icon.bars-3 class="size-5" />
                    </button>
                </div>

                <div x-show="mobileMenuOpen" class="fixed inset-0 z-40" x-transition.opacity>
                    <button type="button" class="absolute inset-0 bg-zinc-950/50" @click="mobileMenuOpen = false" aria-label="Close instructor menu"></button>

                    <aside class="absolute right-0 top-0 flex h-full w-80 max-w-[85vw] flex-col border-l border-zinc-200 bg-white shadow-2xl dark:border-zinc-800 dark:bg-zinc-900"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full">
                        <div class="flex items-center justify-between border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/logo-transparan.webp') }}" alt="Inovindo" class="h-11 w-11 rounded-xl object-contain">
                                <span class="text-sm font-bold text-zinc-900 dark:text-white">Instructor Menu</span>
                            </div>
                            <button type="button" @click="mobileMenuOpen = false" class="rounded-xl p-2 text-zinc-500 transition hover:bg-zinc-100 dark:hover:bg-zinc-800" aria-label="Close instructor menu">
                                <flux:icon.x-mark class="size-5" />
                            </button>
                        </div>

                        <nav class="flex-1 space-y-1 overflow-y-auto p-4">
                            <a href="{{ route('instructor.dashboard') }}"
                                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('instructor.dashboard') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                                <flux:icon.home class="size-5" />
                                Dashboard
                            </a>
                            <a href="{{ route('instructor.courses.index') }}"
                                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('instructor.courses.index') || request()->routeIs('instructor.courses.create') || request()->routeIs('instructor.courses.edit') || request()->routeIs('instructor.courses.preview') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                                <flux:icon.book-open class="size-5" />
                                My Courses
                            </a>
                            <div>
                                <a href="{{ route('instructor.discussions.index') }}"
                                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('instructor.discussions.*') || request()->routeIs('instructor.courses.discussions') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                                    <flux:icon.chat-bubble-left-right class="size-5" />
                                    <span class="flex-1">Discussions</span>
                                    @if ($unreadDiscussions > 0)
                                        <span class="flex h-5 min-w-[20px] items-center justify-center rounded-full bg-amber-500 px-1.5 text-[11px] font-bold text-white tabular-nums">{{ $unreadDiscussions }}</span>
                                    @endif
                                </a>

                                @if ((request()->routeIs('instructor.discussions.*') || request()->routeIs('instructor.courses.discussions')) && $sidebarCourses->isNotEmpty())
                                    <div class="ml-3 mt-1 space-y-0.5 border-l border-zinc-200 pl-3 dark:border-zinc-700">
                                        @foreach ($sidebarCourses as $sc)
                                            <a href="{{ route('instructor.courses.discussions', $sc) }}"
                                                class="flex items-center justify-between rounded-xl px-3 py-2 text-xs font-medium transition
                                                    {{ request()->route('course')?->id === $sc->id ? 'bg-indigo-500/10 text-indigo-400' : 'text-zinc-500 hover:text-zinc-300' }}">
                                                <span class="truncate">{{ $sc->title }}</span>
                                                @if ($sc->discussions_count > 0)
                                                    <span class="ml-2 flex-shrink-0 rounded-full bg-zinc-800 px-2 py-0.5 text-[11px] tabular-nums text-zinc-400">{{ $sc->discussions_count }}</span>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('instructor.students.index') }}"
                                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('instructor.students.*') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                                <flux:icon.academic-cap class="size-5" />
                                Students
                            </a>
                        </nav>

                        <div class="border-t border-zinc-200 p-4 dark:border-zinc-800">
                            <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                                <button type="button" @click="open = ! open"
                                    class="group flex w-full items-center gap-3 rounded-2xl p-3 text-left transition hover:bg-zinc-100 dark:hover:bg-zinc-800">
                                    <img
                                        src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                        alt="{{ auth()->user()->name }}"
                                        class="size-10 rounded-full object-cover ring-1 ring-zinc-200 dark:ring-zinc-700">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-semibold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</p>
                                        <p class="truncate text-xs text-zinc-500 dark:text-zinc-400">{{ auth()->user()->email }}</p>
                                    </div>
                                    <flux:icon.chevron-up class="size-4 shrink-0 text-zinc-400 transition group-hover:text-zinc-600 dark:group-hover:text-zinc-300" ::class="open ? 'rotate-180' : ''" />
                                </button>

                                <div x-show="open" x-transition.origin.bottom class="absolute bottom-full left-0 right-0 mb-2 overflow-hidden rounded-2xl border border-zinc-200 bg-white p-2 shadow-xl dark:border-zinc-800 dark:bg-zinc-900">
                                    <a href="{{ route('instructor.profile') }}"
                                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white">
                                        <flux:icon.user-circle class="size-5" />
                                        Profile
                                    </a>

                                    <button type="button" x-data x-on:click="$flux.dark = ! $flux.dark"
                                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white"
                                        aria-label="Toggle dark mode">
                                        <span x-show="$flux.dark" class="inline-flex items-center gap-3">
                                            <flux:icon.sun class="size-5" />
                                            Light Mode
                                        </span>
                                        <span x-show="! $flux.dark" class="inline-flex items-center gap-3">
                                            <flux:icon.moon class="size-5" />
                                            Dark Mode
                                        </span>
                                    </button>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-zinc-600 transition hover:bg-red-50 hover:text-red-600 dark:text-zinc-300 dark:hover:bg-red-500/10 dark:hover:text-red-400">
                                            <flux:icon.arrow-right-start-on-rectangle class="size-5" />
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </header>
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
    <x-toaster-hub />
    @fluxScripts
</body>

</html>
