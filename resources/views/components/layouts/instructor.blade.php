<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Instructor Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-950 dark:text-white">
    <div class="flex">

        <!-- Sidebar -->
        <aside class="sticky top-0 z-10 flex h-screen w-72 flex-col border-r border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex items-center gap-3 border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-sm font-bold text-white">IA</div>
                <span class="text-sm font-bold text-zinc-900 dark:text-white">Instructor</span>
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
                            {{ request()->routeIs('instructor.courses.index') || request()->routeIs('instructor.courses.create') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                        <flux:icon.book-open class="size-5" />
                        My Courses
                    </a>

                    @if (request()->routeIs('instructor.courses.*') && $sidebarCourses->isNotEmpty())
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
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('instructor.students.*') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    <flux:icon.academic-cap class="size-5" />
                    Students
                </a>

                <a href="{{ route('instructor.discussions.index') }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('instructor.discussions.*') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    <flux:icon.chat-bubble-left-right class="size-5" />
                    <span class="flex-1">Discussions</span>
                    @if ($unreadDiscussions > 0)
                        <span class="flex h-5 min-w-[20px] items-center justify-center rounded-full bg-amber-500 px-1.5 text-[11px] font-bold text-white tabular-nums">{{ $unreadDiscussions }}</span>
                    @endif
                </a>

                <a href="{{ route('instructor.profile') }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
                        {{ request()->routeIs('instructor.profile') ? 'bg-indigo-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    <flux:icon.user class="size-5" />
                    Profile
                </a>

            </nav>

            <div class="border-t border-zinc-200 p-4 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-red-500 transition hover:bg-red-50 dark:hover:bg-red-500/10">
                            <flux:icon.arrow-right-start-on-rectangle class="size-5" />
                            Logout
                        </button>
                    </form>

                    <div class="relative">
                        <flux:icon.bell class="size-5 text-zinc-400" />
                        @if ($unreadNotifications > 0)
                            <span class="absolute -right-1 -top-1 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white tabular-nums">{{ $unreadNotifications }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex flex-1 flex-col p-6 min-w-0">
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
    <x-toaster-hub />
</body>

</html>
