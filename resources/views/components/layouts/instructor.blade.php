<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Instructor Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-950 dark:text-white">
    <div class=" flex">

        <!-- Sidebar -->
        <aside
            class="z-10 sticky top-0  h-screen  inset-y-0 left-0 hidden lg:flex w-72 flex-col border-r border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
            <nav class="flex-1 p-4 h-full space-y-2 overflow-y-auto scroll-hide">

                <a href="{{ route('instructor.dashboard') }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('instructor.dashboard') }}
                ? 'bg-indigo-600 text-white'
                : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    <flux:icon.home class="size-5" />
                    Dashboard
                </a>

                <a href="{{ route('instructor.courses.index') }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('instructor.courses.*')
                ? 'bg-indigo-600 text-white'
                : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    <flux:icon.book-open class="size-5" />
                    My Courses
                </a>

                <a href="{{ route('instructor.students.index') }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('instructor.students.*')
                ? 'bg-indigo-600 text-white'
                : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    <flux:icon.academic-cap class="size-5" />
                    Students
                </a>

                <a href="{{ route('instructor.discussions.index') }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('instructor.discussions.*')
                ? 'bg-indigo-600 text-white'
                : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    <flux:icon.chat-bubble-left-right class="size-5" />
                    Discussions
                </a>

                <a href="{{ route('instructor.profile') }}"
                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('instructor.profile')
                ? 'bg-indigo-600 text-white'
                : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    <flux:icon.user class="size-5" />
                    Profile
                </a>

            </nav>

            <div class="border-t border-zinc-200 p-4 dark:border-zinc-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-red-500 transition hover:bg-red-50 dark:hover:bg-red-500/10">
                        <flux:icon.arrow-right-start-on-rectangle class="size-5" />
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col m-6 min-w-0">
            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
    <x-toaster-hub />
</body>

</html>
