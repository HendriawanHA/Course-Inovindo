<div class="space-y-6 sm:space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white sm:text-3xl">Students</h1>
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
            Pantau student yang mengikuti course kamu.
        </p>
    </div>

    <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
        <label for="student-course-filter" class="text-sm font-semibold text-zinc-900 dark:text-white">Filter Course</label>
        <div class="mt-2 flex flex-col gap-3 sm:flex-row sm:items-center">
            <select
                id="student-course-filter"
                wire:model.live="courseId"
                class="w-full rounded-lg border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white sm:max-w-sm"
            >
                <option value="">Semua course</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>

            @if ($courseId !== '')
                <button type="button" wire:click="$set('courseId', '')" class="inline-flex items-center justify-center rounded-lg px-3 py-2 text-sm font-semibold text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white">
                    Reset filter
                </button>
            @endif
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <div class="hidden grid-cols-12 border-b border-zinc-200 px-6 py-4 text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:border-zinc-800 dark:text-zinc-400 md:grid">
            <div class="col-span-4">Student</div>
            <div class="col-span-4">Course</div>
            <div class="col-span-2">Progress</div>
            <div class="col-span-2">Enrolled</div>
        </div>

        @forelse ($enrollments as $enrollment)
            @php
                $progress = $enrollment->progress;

                $color = $progress >= 100 ? 'bg-emerald-500' : ($progress >= 50 ? 'bg-indigo-500' : 'bg-amber-500');
            @endphp

            <div class="border-b border-zinc-200 px-4 py-5 last:border-b-0 dark:border-zinc-800 sm:px-6 md:grid md:grid-cols-12 md:items-center md:py-4">
                <div class="flex items-center gap-3 md:col-span-4">
                    <img
                        src="{{ $enrollment->user->avatar
                                ? asset('storage/' . $enrollment->user->avatar)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($enrollment->user->name) }}"
                        class="h-11 w-11 shrink-0 rounded-full object-cover md:h-10 md:w-10">

                    <div class="min-w-0">
                        <p class="truncate font-semibold text-zinc-900 dark:text-white">
                            {{ $enrollment->user->name }}
                        </p>
                        <p class="truncate text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $enrollment->user->email }}
                        </p>
                    </div>
                </div>

                <div class="mt-4 md:col-span-4 md:mt-0">
                    <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400 md:hidden">Course</p>
                    <p class="mt-1 font-medium text-zinc-900 dark:text-white md:mt-0">
                        {{ $enrollment->course->title }}
                    </p>
                </div>

                <div class="mt-4 md:col-span-2 md:mt-0">
                    <div class="flex items-center justify-between gap-3 md:block">
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400 md:hidden">Progress</p>
                        <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-200 md:hidden">{{ $progress }}%</p>
                    </div>

                    <div class="mt-2 h-2 w-full rounded-full bg-zinc-200 md:mt-0 dark:bg-zinc-800">
                        <div
                            class="h-2 rounded-full {{ $color }} transition-all duration-500"
                            style="width: {{ $progress }}%">
                        </div>
                    </div>

                    <p class="mt-1 hidden text-xs text-zinc-500 md:block dark:text-zinc-400">
                        {{ $progress }}%
                    </p>
                </div>

                <div class="mt-4 flex items-center justify-between gap-3 text-sm md:col-span-2 md:mt-0 md:block md:text-zinc-500 md:dark:text-zinc-400">
                    <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400 md:hidden">Enrolled</p>
                    <p class="font-medium text-zinc-700 dark:text-zinc-200 md:font-normal md:text-inherit">
                        {{ $enrollment->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="p-6 text-center sm:p-10">
                <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $search === '' && $courseId === '' ? 'Belum ada student' : 'Student tidak ditemukan' }}</h3>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ $search === '' && $courseId === '' ? 'Student yang enroll di course kamu akan muncul di sini.' : 'Coba gunakan filter atau kata kunci lain.' }}
                </p>
            </div>
        @endforelse
    </div>

    @if ($enrollments->hasPages())
        <div>
            {{ $enrollments->links() }}
        </div>
    @endif
</div>
