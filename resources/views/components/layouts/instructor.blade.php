<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Instructor Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-950 dark:text-white">
    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside
            class="hidden lg:flex w-72 flex-col border-r border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
                <h1 class="text-lg font-bold">
                    Inovindo Academy
                </h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    Instructor Panel
                </p>
            </div>

            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('instructor.dashboard') }}"
                    class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('instructor.dashboard')
                       ? 'bg-indigo-600 text-white'
                       : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    Dashboard
                </a>

                <a href="{{ route('instructor.discussions.index') }}"
                    class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('instructor.discussions.*')
                       ? 'bg-indigo-600 text-white'
                       : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    Discussions
                </a>

                <a href="{{ route('instructor.courses.index') }}"
                    class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('instructor.courses.*')
                       ? 'bg-indigo-600 text-white'
                       : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    My Courses
                </a>

                <a href="{{ route('instructor.students.index') }}"
                    class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition
                   {{ request()->routeIs('instructor.students.*')
                       ? 'bg-indigo-600 text-white'
                       : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                    Students
                </a>
            </nav>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Topbar -->
            <header
                class="h-20 border-b border-zinc-200 bg-white px-6 flex items-center justify-between dark:border-zinc-800 dark:bg-zinc-900">
                <div>
                    <h2 class="text-xl font-bold">
                        {{ $title ?? 'Instructor Dashboard' }}
                    </h2>

                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Manage your courses, discussions, and students.
                    </p>
                </div>

                


                    <!-- Dropdown -->
                    <livewire:instructor.profile-dropdown />


            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    <x-toaster-hub />
</body>

</html>
