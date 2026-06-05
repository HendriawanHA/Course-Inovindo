<div class="space-y-8">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">My Courses</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                Kelola course yang kamu buat sebagai instruktur.
            </p>
        </div>

        <a href="{{ route('instructor.courses.create') }}" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
            New Course
        </a>
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($courses as $course)
            <div
                class="group overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-xl shadow-black/5 transition duration-300 hover:-translate-y-1 hover:border-indigo-500/50 hover:shadow-indigo-500/10 dark:border-zinc-800 dark:bg-zinc-900/80 dark:shadow-black/10">

                <!-- Thumbnail -->
                <div class="relative h-52 overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                    @if ($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    @else
                        <div
                            class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-900">
                            <div class="text-center">
                                <div
                                    class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-500/10 text-indigo-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">No Thumbnail</p>
                            </div>
                        </div>
                    @endif

                    <!-- Top overlay -->
                    <div class="absolute inset-x-0 top-0 flex items-start justify-between p-4">
                        <span
                            class="rounded-full border px-3 py-1 text-xs font-semibold backdrop-blur-xl
                {{ $course->is_published
                    ? 'border-green-400/30 bg-green-500/15 text-green-300'
                    : 'border-yellow-400/30 bg-yellow-500/15 text-yellow-300' }}">
                            {{ $course->is_published ? 'Published' : 'Draft' }}
                        </span>

                        <span
                            class="rounded-full border border-white/10 bg-black/40 px-3 py-1 text-xs font-semibold text-white backdrop-blur-xl">
                            Rp {{ number_format($course->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Gradient -->
                    <div
                        class="pointer-events-none absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-zinc-900 to-transparent">
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5">
                    <div class="min-h-[96px]">
                        <h2 class="line-clamp-1 text-lg font-bold text-zinc-900 dark:text-white">
                            {{ $course->title }}
                        </h2>

                        <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">
                            {{ $course->description ?? 'Tidak ada deskripsi untuk course ini.' }}
                        </p>
                    </div>

                    <!-- Meta -->
                    <div class="mt-5 grid grid-cols-3 gap-3 rounded-2xl border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-zinc-950/50">
                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Modules</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-900 dark:text-white">
                                {{ $course->modules_count ?? ($course->modules?->count() ?? 0) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Lessons</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-900 dark:text-white">
                                {{ $course->lessons_count ?? 0 }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[11px] uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Diskusi</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-900 dark:text-white">
                                {{ $course->discussions_count ?? 0 }}
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-5 flex items-center gap-2">
                        <a href="{{ route('instructor.courses.preview', $course) }}"
                            class="flex-1 rounded-2xl border border-zinc-300 px-4 py-3 text-center text-sm font-semibold text-zinc-700 transition hover:border-indigo-500/50 hover:bg-indigo-500/10 hover:text-indigo-600 dark:border-zinc-700 dark:text-zinc-200 dark:hover:text-white">
                            Preview
                        </a>

                        <a href="{{ route('instructor.courses.edit', $course) }}"
                            class="flex-1 rounded-2xl bg-indigo-600 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-indigo-500">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="rounded-3xl border border-dashed border-zinc-300 bg-white p-10 text-center dark:border-zinc-700 dark:bg-zinc-900 md:col-span-2 xl:col-span-3">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Belum ada course</h3>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                    Buat course pertama kamu sebagai instruktur.
                </p>
            </div>
        @endforelse
    </div>

</div>
