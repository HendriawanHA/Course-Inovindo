<x-layouts.instructor>
    <div class="space-y-6 sm:space-y-8">

        <section class="rounded-3xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900 sm:p-6">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ auth()->user()?->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" class="h-16 w-16 rounded-2xl object-cover sm:h-20 sm:w-20">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</h1>
                            <span class="rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-semibold text-indigo-600 dark:text-indigo-300">Instructor</span>
                        </div>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ auth()->user()->headline ?? 'Kelola course, student, dan diskusi dari satu tempat.' }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">
                    <a href="{{ route('instructor.courses.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        <flux:icon.plus class="size-4" /> New Course
                    </a>
                    <a href="{{ route('instructor.profile') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-zinc-200 px-5 py-3 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        <flux:icon.pencil-square class="size-4" /> Edit Profile
                    </a>
                </div>
            </div>
        </section>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Courses</p>
                <div class="mt-2 flex items-end justify-between gap-3">
                    <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalCourses }}</p>
                    <p class="text-right text-xs text-zinc-500 dark:text-zinc-400">{{ $publishedCourses }} published<br>{{ $draftCourses }} draft</p>
                </div>
            </div>
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Students</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalStudents }}</p>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Active atau completed enrollments</p>
            </div>
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Unanswered Discussions</p>
                <p class="mt-2 text-3xl font-bold {{ $totalUnansweredDiscussions > 0 ? 'text-amber-500' : 'text-zinc-900 dark:text-white' }}">{{ $totalUnansweredDiscussions }}</p>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Dari {{ $totalDiscussions }} total diskusi</p>
            </div>
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Completion Rate</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ $completionRate }}%</p>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Berdasarkan enrollment selesai</p>
            </div>
        </div>

        <section class="rounded-3xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Perlu Tindakan</h2>
                    <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">Prioritas yang paling berdampak untuk course kamu.</p>
                </div>
                @if ($readyToPublishCourses->isNotEmpty())
                    <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-600 dark:text-emerald-300">{{ $readyToPublishCourses->count() }} course siap publish</span>
                @endif
            </div>

            <div class="mt-5 grid gap-3 lg:grid-cols-3">
                <a href="{{ $topUnansweredCourse ? route('instructor.courses.discussions', $topUnansweredCourse) : route('instructor.discussions.index') }}" class="rounded-2xl border border-amber-500/20 bg-amber-500/5 p-4 transition hover:border-amber-500/40">
                    <div class="flex items-center justify-between gap-3">
                        <p class="font-semibold text-zinc-900 dark:text-white">{{ $totalUnansweredDiscussions }} diskusi belum dibalas</p>
                        <flux:icon.chat-bubble-left-right class="size-5 text-amber-500" />
                    </div>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $topUnansweredCourse ? 'Terbanyak di ' . $topUnansweredCourse->title : 'Belum ada diskusi yang perlu dibalas.' }}</p>
                </a>

                <a href="{{ $coursesNeedingThumbnail->first() ? route('instructor.courses.edit', $coursesNeedingThumbnail->first()) : route('instructor.courses.index') }}" class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 transition hover:border-indigo-500/30 hover:bg-indigo-500/5 dark:border-zinc-800 dark:bg-zinc-950/40">
                    <div class="flex items-center justify-between gap-3">
                        <p class="font-semibold text-zinc-900 dark:text-white">{{ $coursesNeedingThumbnail->count() }} course perlu thumbnail</p>
                        <flux:icon.photo class="size-5 text-zinc-500" />
                    </div>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Thumbnail wajib sebelum course dipublish.</p>
                </a>

                <a href="{{ $coursesNeedingLesson->first() ? route('instructor.courses.edit', $coursesNeedingLesson->first()) : route('instructor.courses.index') }}" class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 transition hover:border-indigo-500/30 hover:bg-indigo-500/5 dark:border-zinc-800 dark:bg-zinc-950/40">
                    <div class="flex items-center justify-between gap-3">
                        <p class="font-semibold text-zinc-900 dark:text-white">{{ $coursesNeedingLesson->count() }} course perlu lesson</p>
                        <flux:icon.play-circle class="size-5 text-zinc-500" />
                    </div>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Minimal 1 lesson agar course siap dipublish.</p>
                </a>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[1fr_380px]">
            <section class="rounded-3xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Course Terbaru</h2>
                        <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">Menampilkan maksimal 5 course terbaru dari {{ $totalCourses }} course.</p>
                    </div>
                    <a href="{{ route('instructor.courses.index') }}" class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-500 dark:text-indigo-400">Lihat Semua</a>
                </div>

                @if ($dashboardCourses->isEmpty())
                    <div class="mt-8 rounded-2xl border border-dashed border-zinc-300 p-8 text-center dark:border-zinc-700">
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

                                if (! $course->is_published && ! $course->thumbnail) {
                                    $statusLabel = 'Needs Thumbnail';
                                    $statusClass = 'bg-rose-500/10 text-rose-600 dark:text-rose-300';
                                } elseif (! $course->is_published && $course->lessons_count === 0) {
                                    $statusLabel = 'Needs Lesson';
                                    $statusClass = 'bg-rose-500/10 text-rose-600 dark:text-rose-300';
                                } elseif (! $course->is_published && $course->thumbnail && $course->lessons_count > 0) {
                                    $statusLabel = 'Ready to Publish';
                                    $statusClass = 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-300';
                                }
                            @endphp

                            <div class="flex flex-col gap-4 py-4 first:pt-0 last:pb-0 sm:flex-row sm:items-center">
                                <div class="h-16 w-24 flex-shrink-0 overflow-hidden rounded-2xl bg-zinc-100 dark:bg-zinc-800">
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
                                        @if ($course->unanswered_discussions_count > 0)
                                            <span class="rounded-full bg-amber-500/15 px-2 py-0.5 font-semibold text-amber-600 dark:text-amber-300">{{ $course->unanswered_discussions_count }} belum dibalas</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center justify-between gap-2 sm:justify-end">
                                    <span class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $course->price > 0 ? 'Rp' . number_format($course->price, 0, ',', '.') : 'Free' }}</span>
                                    <a href="{{ route('instructor.courses.edit', $course) }}" class="rounded-xl border border-zinc-300 px-3 py-2 text-xs font-semibold text-zinc-600 transition hover:border-indigo-500 hover:text-indigo-600 dark:border-zinc-700 dark:text-zinc-300 dark:hover:text-indigo-400">Manage</a>
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
                                        <p class="mt-0.5 text-xs text-zinc-600 dark:text-zinc-500">{{ $enrollment->created_at->diffForHumans() }}</p>
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
