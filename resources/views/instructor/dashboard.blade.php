<x-layouts.instructor>
    <div class="space-y-6 sm:space-y-8">

        {{-- HERO --}}
        <section class="overflow-hidden rounded-3xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
            <div class="h-28 sm:h-40"></div>
            <div class="relative px-5 pb-6 sm:px-8 sm:pb-8">
                <div class="-mt-16 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-end">
                        <img src="{{ auth()->user()?->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" class="h-24 w-24 rounded-full object-cover shadow-2xl shadow-black/40 sm:h-32 sm:w-32">
                        <div class="pb-2">
                            <div class="flex flex-wrap items-center gap-3">
                                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white sm:text-3xl">{{ auth()->user()->name }}</h1>
                                <span class="rounded-full bg-indigo-500/20 px-3 py-1 text-xs font-semibold text-indigo-300">Instructor</span>
                            </div>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ auth()->user()->headline ?? 'Instructor di Inovindo Academy' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('instructor.profile') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500 sm:w-auto">
                        <flux:icon.pencil-square class="size-4" /> Edit Profile
                    </a>
                </div>
            </div>
        </section>

        @if ($totalUnansweredDiscussions > 0)
            <section class="flex flex-col gap-4 rounded-3xl border border-amber-500/30 bg-amber-500/10 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div class="flex items-start gap-3">
                    <div class="flex size-11 shrink-0 items-center justify-center rounded-2xl bg-amber-500/20 text-amber-300">
                        <flux:icon.chat-bubble-left-right class="size-5" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-zinc-900 dark:text-white">{{ $totalUnansweredDiscussions }} diskusi belum dibalas</h2>
                        <p class="mt-1 text-sm text-amber-100/80">Balas pertanyaan student agar notifikasi diskusi dashboard tetap bersih.</p>
                    </div>
                </div>
                <a href="{{ route('instructor.discussions.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-amber-400">
                    Lihat Diskusi
                </a>
            </section>
        @endif

        {{-- STATS CARDS --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Courses</p>
                <p class="mt-1 text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalCourses }}</p>
            </div>
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Lessons</p>
                <p class="mt-1 text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalLessons }}</p>
            </div>
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Students</p>
                <p class="mt-1 text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalStudents }}</p>
            </div>
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Discussions</p>
                <p class="mt-1 text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalDiscussions }}</p>
            </div>
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Completion</p>
                <p class="mt-1 text-2xl font-bold text-zinc-900 dark:text-white">{{ $completionRate }}%</p>
            </div>
        </div>

        {{-- MAIN GRID --}}
        <div class="grid gap-6 xl:grid-cols-[1fr_380px]">

            {{-- LEFT: COURSES --}}
            <section class="rounded-3xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white">My Courses</h2>
                        <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">{{ $totalCourses }} course{{ $totalCourses !== 1 ? 's' : '' }}</p>
                    </div>
                    <a href="{{ route('instructor.courses.create') }}" class="shrink-0 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">+ New Course</a>
                </div>

                @if ($courses->isEmpty())
                    <div class="mt-8 text-center">
                        <p class="text-zinc-500 dark:text-zinc-400">Belum ada course. Buat course pertamamu!</p>
                        <a href="{{ route('instructor.courses.create') }}" class="mt-4 inline-block rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">Buat Course</a>
                    </div>
                @else
                    <div class="mt-6 divide-y divide-zinc-200 dark:divide-zinc-800">
                        @foreach ($courses as $course)
                            <div class="flex flex-col gap-4 py-4 first:pt-0 last:pb-0 sm:flex-row sm:items-center">
                                <div class="h-14 w-20 flex-shrink-0 overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800">
                                    @if ($course->thumbnail)
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <a href="{{ route('instructor.courses.edit', $course) }}" class="font-semibold text-zinc-900 transition hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400">{{ $course->title }}</a>
                                    <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-zinc-500 dark:text-zinc-400">
                                        <span>{{ $course->enrollments_count }} student{{ $course->enrollments_count !== 1 ? 's' : '' }}</span>
                                        <span>&middot;</span>
                                        <a href="{{ route('instructor.courses.discussions', $course) }}" class="transition hover:text-indigo-400">{{ $course->discussions_count }} discussion{{ $course->discussions_count !== 1 ? 's' : '' }}</a>
                                        @if ($course->unanswered_discussions_count > 0)
                                            <span class="rounded-full bg-amber-500/15 px-2 py-0.5 font-semibold text-amber-300">{{ $course->unanswered_discussions_count }} belum dibalas</span>
                                        @endif
                                        <span>&middot;</span>
                                        <span class="{{ $course->is_published ? 'text-emerald-400' : 'text-amber-400' }}">{{ $course->is_published ? 'Published' : 'Draft' }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between gap-2 sm:justify-end">
                                    @if ($course->price > 0)
                                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">Rp{{ number_format($course->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-sm font-semibold text-emerald-400">Free</span>
                                    @endif
                                    <a href="{{ route('instructor.courses.discussions', $course) }}" class="rounded-lg border border-zinc-300 p-2 text-zinc-500 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-zinc-700 dark:text-zinc-400 dark:hover:text-indigo-400" title="Discussions">
                                        <flux:icon.chat-bubble-left-right class="size-4" />
                                    </a>
                                    <a href="{{ route('instructor.courses.edit', $course) }}" class="rounded-lg border border-zinc-300 p-2 text-zinc-500 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-zinc-700 dark:text-zinc-400 dark:hover:text-indigo-400" title="Edit">
                                        <flux:icon.pencil-square class="size-4" />
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($totalRevenue > 0)
                        <div class="mt-6 rounded-2xl bg-zinc-50 p-4 dark:bg-zinc-950/50">
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Revenue</p>
                            <p class="text-xl font-bold text-zinc-900 dark:text-white">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    @endif
                @endif
            </section>

            {{-- RIGHT: RECENT ACTIVITY --}}
            <div class="space-y-6">
                <section class="rounded-3xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
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
                                        <p class="mt-0.5 text-xs text-zinc-600">{{ $enrollment->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <section class="rounded-3xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Quick Links</h2>
                    <div class="mt-4 space-y-2">
                        <a href="{{ route('instructor.courses.index') }}" class="flex items-center justify-between rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-700 transition hover:border-indigo-500/30 hover:bg-indigo-500/5 dark:border-zinc-800 dark:bg-zinc-950/40 dark:text-zinc-300">
                            <span>Manage Courses</span>
                            <flux:icon.chevron-right class="size-4 text-zinc-500" />
                        </a>
                        <a href="{{ route('instructor.discussions.index') }}" class="flex items-center justify-between rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-700 transition hover:border-indigo-500/30 hover:bg-indigo-500/5 dark:border-zinc-800 dark:bg-zinc-950/40 dark:text-zinc-300">
                            <span>Discussions</span>
                            <span class="inline-flex items-center gap-2">
                                @if ($totalUnansweredDiscussions > 0)
                                    <span class="rounded-full bg-amber-500 px-2 py-0.5 text-[11px] font-bold text-zinc-950 tabular-nums">{{ $totalUnansweredDiscussions }}</span>
                                @endif
                                <flux:icon.chevron-right class="size-4 text-zinc-500" />
                            </span>
                        </a>
                        <a href="{{ route('instructor.students.index') }}" class="flex items-center justify-between rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-700 transition hover:border-indigo-500/30 hover:bg-indigo-500/5 dark:border-zinc-800 dark:bg-zinc-950/40 dark:text-zinc-300">
                            <span>Students</span>
                            <flux:icon.chevron-right class="size-4 text-zinc-500" />
                        </a>
                    </div>
                </section>
            </div>

        </div>

    </div>
</x-layouts.instructor>
