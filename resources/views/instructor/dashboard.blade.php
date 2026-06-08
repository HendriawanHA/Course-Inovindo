<x-layouts.instructor>
    <div class="space-y-6 sm:space-y-8">

        <section class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900 sm:p-6">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ auth()->user()?->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" class="h-16 w-16 rounded-full object-cover sm:h-20 sm:w-20">
                    <div>
                        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</h1>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ auth()->user()->headline ?? 'Kelola course, student, dan diskusi dari satu tempat.' }}</p>
                    </div>
                </div>

                <a href="{{ route('instructor.courses.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    <flux:icon.plus class="size-4" /> New Course
                </a>
            </div>
        </section>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Courses</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalCourses }}</p>
            </div>
            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Students</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalStudents }}</p>
            </div>
            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Unanswered Discussions</p>
                <p class="mt-2 text-3xl font-bold text-amber-600 dark:text-amber-300">{{ $totalUnansweredDiscussions }}</p>
            </div>
        </div>

        @if ($totalUnansweredDiscussions > 0)
            <section class="flex flex-col gap-4 rounded-xl border border-amber-400/30 bg-amber-400/10 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div>
                    <h2 class="font-semibold text-zinc-900 dark:text-white">{{ $totalUnansweredDiscussions }} diskusi belum dibalas</h2>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">Balas pertanyaan student agar proses belajar tetap aktif.</p>
                </div>
                <a href="{{ route('instructor.discussions.index') }}" class="inline-flex items-center justify-center rounded-lg bg-amber-400 px-4 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-amber-300">
                    Lihat Diskusi
                </a>
            </section>
        @endif

        <div class="grid gap-6 xl:grid-cols-[1fr_380px]">
            <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Course Terbaru</h2>
                        <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">Menampilkan maksimal 5 course terbaru.</p>
                    </div>
                    <a href="{{ route('instructor.courses.index') }}" class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-500 dark:text-indigo-400">Lihat Semua</a>
                </div>

                @if ($dashboardCourses->isEmpty())
                    <div class="mt-8 rounded-xl border border-dashed border-zinc-300 p-8 text-center dark:border-zinc-700">
                        <p class="font-semibold text-zinc-900 dark:text-white">Belum ada course</p>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Buat course pertama untuk mulai mengajar.</p>
                        <a href="{{ route('instructor.courses.create') }}" class="mt-4 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">Buat Course</a>
                    </div>
                @else
                    <div class="mt-6 divide-y divide-zinc-200 dark:divide-zinc-800">
                        @foreach ($dashboardCourses as $course)
                            @php
                                $statusLabel = $course->is_published ? 'Published' : 'Draft';
                                $statusClass = $course->is_published ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300' : 'bg-amber-500/10 text-amber-600 dark:text-amber-300';

                                if (! $course->is_published && (! $course->thumbnail || $course->lessons_count === 0)) {
                                    $statusLabel = 'Incomplete';
                                    $statusClass = 'bg-rose-500/10 text-rose-600 dark:text-rose-300';
                                }
                            @endphp

                            <div class="flex flex-col gap-4 py-4 first:pt-0 last:pb-0 sm:flex-row sm:items-center">
                                <div class="h-16 w-24 flex-shrink-0 overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800">
                                    @if ($course->thumbnail)
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-zinc-400">
                                            <flux:icon.photo class="size-5" />
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('instructor.courses.edit', $course) }}" class="font-semibold text-zinc-900 transition hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400">{{ $course->title }}</a>
                                        <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                                    </div>
                                    <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-zinc-500 dark:text-zinc-400">
                                        <span>{{ $course->enrollments_count }} student{{ $course->enrollments_count !== 1 ? 's' : '' }}</span>
                                        <span>{{ $course->lessons_count }} lesson{{ $course->lessons_count !== 1 ? 's' : '' }}</span>
                                        <a href="{{ route('instructor.courses.discussions', $course) }}" class="transition hover:text-indigo-500">{{ $course->discussions_count }} discussion{{ $course->discussions_count !== 1 ? 's' : '' }}</a>
                                    </div>
                                </div>
                                <a href="{{ route('instructor.courses.edit', $course) }}" class="inline-flex items-center justify-center rounded-xl border border-zinc-300 px-3 py-2 text-xs font-semibold text-zinc-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-zinc-700 dark:text-zinc-300 dark:hover:text-indigo-400">Manage</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Recent Activity</h2>
                <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">Student enrollments terbaru</p>

                @if ($recentEnrollments->isEmpty())
                    <p class="mt-6 text-sm text-zinc-500 dark:text-zinc-400">Belum ada aktivitas enrollments.</p>
                @else
                    <div class="mt-5 space-y-4">
                        @foreach ($recentEnrollments as $enrollment)
                            <div class="flex items-start gap-3">
                                <img src="{{ $enrollment->user->avatar ? asset('storage/' . $enrollment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($enrollment->user->name) . '&background=6366f1&color=fff' }}" class="mt-0.5 h-8 w-8 flex-shrink-0 rounded-full object-cover">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $enrollment->user->name }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">enrolled in <span class="text-zinc-700 dark:text-zinc-300">{{ $enrollment->course->title }}</span></p>
                                    <p class="mt-0.5 text-xs text-zinc-600 dark:text-zinc-500">{{ $enrollment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

    </div>
</x-layouts.instructor>
