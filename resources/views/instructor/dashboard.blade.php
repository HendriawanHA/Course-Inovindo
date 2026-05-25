<x-layouts.instructor title="Instructor Dashboard">
    <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 px-6 py-8">
        <div class="mx-auto max-w-6xl">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                Instructor Dashboard
            </h1>

            <p class="mt-1 text-zinc-500 dark:text-zinc-400">
                Kelola course dan diskusi student dari satu tempat.
            </p>

            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Course</p>
                    <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                        {{ $courses->count() }}
                    </h2>
                </div>

                <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Diskusi</p>
                    <h2 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                        {{ $discussionCount }}
                    </h2>
                </div>
            </div>

            <div class="mt-8">
                <a href="{{ route('instructor.discussions.index') }}"
                    class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                    Lihat Diskusi
                </a>
            </div>
        </div>
    </div>
</x-layouts.instructor>
