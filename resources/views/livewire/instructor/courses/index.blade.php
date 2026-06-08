<div class="space-y-8">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">My Courses</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                Kelola course yang kamu buat sebagai instruktur.
            </p>
        </div>

        <div class="flex items-center gap-3">
            {{-- View Toggle --}}
            <div class="flex items-center rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-800">
                <button
                    wire:click="$set('view', 'grid')"
                    class="flex items-center gap-1.5 rounded-l-xl px-3 py-2 text-sm font-medium transition
                        {{ $view === 'grid' ? 'bg-indigo-600 text-white' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}"
                    aria-label="Grid view">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                </button>
                <button
                    wire:click="$set('view', 'list')"
                    class="flex items-center gap-1.5 rounded-r-xl px-3 py-2 text-sm font-medium transition
                        {{ $view === 'list' ? 'bg-indigo-600 text-white' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}"
                    aria-label="List view">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                    </svg>
                </button>
            </div>

            <a href="{{ route('instructor.courses.create') }}" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                New Course
            </a>
        </div>
    </div>

    <div class="space-y-2">
        <x-instructor.search-input placeholder="Cari course berdasarkan judul atau deskripsi..." />

        @if ($search !== '')
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Menampilkan {{ $courses->count() }} hasil untuk "{{ $search }}".
            </p>
        @endif
    </div>

    {{-- GRID VIEW --}}
    @if ($view === 'grid')
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

                            <div class="flex items-center gap-2">
                                <span class="flex items-center gap-1.5 rounded-full border border-white/10 bg-black/40 px-3 py-1 text-xs font-semibold text-white backdrop-blur-xl">
                                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128H5.228A2 2 0 0 1 5 17.119V5a2 2 0 0 1 2-2h6" />
                                    </svg>
                                    {{ $course->enrollments_count ?? 0 }}
                                </span>
                                <span
                                    class="rounded-full border border-white/10 bg-black/40 px-3 py-1 text-xs font-semibold text-white backdrop-blur-xl">
                                    Rp {{ number_format($course->price, 0, ',', '.') }}
                                </span>
                            </div>
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
                    <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $search === '' ? 'Belum ada course' : 'Course tidak ditemukan' }}</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $search === '' ? 'Buat course pertama kamu sebagai instruktur.' : 'Coba gunakan kata kunci lain.' }}
                    </p>
                </div>
            @endforelse
        </div>
    @endif

    {{-- LIST VIEW --}}
    @if ($view === 'list')
        <div class="space-y-3">
            @forelse ($courses as $course)
                <div
                    class="group flex flex-col gap-4 rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm transition hover:border-indigo-500/50 hover:shadow-md sm:flex-row sm:items-center dark:border-zinc-800 dark:bg-zinc-900/80">

                    {{-- Thumbnail --}}
                    <div class="h-32 w-full shrink-0 overflow-hidden rounded-xl bg-zinc-100 sm:h-20 sm:w-32 dark:bg-zinc-800">
                        @if ($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="line-clamp-1 text-base font-bold text-zinc-900 dark:text-white">
                                {{ $course->title }}
                            </h2>
                            <span
                                class="shrink-0 rounded-full px-2.5 py-0.5 text-[11px] font-semibold
                                {{ $course->is_published ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-amber-500/10 text-amber-600 dark:text-amber-400' }}">
                                {{ $course->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        <p class="mt-1 line-clamp-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $course->description ?? 'Tidak ada deskripsi.' }}
                        </p>

                        <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-zinc-500 dark:text-zinc-400">
                            <span class="flex items-center gap-1">
                                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128H5.228A2 2 0 0 1 5 17.119V5a2 2 0 0 1 2-2h6" />
                                </svg>
                                {{ $course->enrollments_count ?? 0 }} student
                            </span>
                            <span>{{ $course->modules_count ?? 0 }} modules</span>
                            <span>{{ $course->lessons_count ?? 0 }} lessons</span>
                            <span>{{ $course->discussions_count ?? 0 }} diskusi</span>
                            <span class="font-medium text-zinc-700 dark:text-zinc-300">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex shrink-0 items-center gap-2 sm:flex-col">
                        <a href="{{ route('instructor.courses.preview', $course) }}"
                            class="rounded-xl border border-zinc-300 px-4 py-2 text-xs font-semibold text-zinc-700 transition hover:border-indigo-500/50 hover:bg-indigo-500/10 hover:text-indigo-600 dark:border-zinc-700 dark:text-zinc-200 dark:hover:text-white">
                            Preview
                        </a>
                        <a href="{{ route('instructor.courses.edit', $course) }}"
                            class="rounded-xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-indigo-500">
                            Edit
                        </a>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-dashed border-zinc-300 bg-white p-10 text-center dark:border-zinc-700 dark:bg-zinc-900">
                    <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $search === '' ? 'Belum ada course' : 'Course tidak ditemukan' }}</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $search === '' ? 'Buat course pertama kamu sebagai instruktur.' : 'Coba gunakan kata kunci lain.' }}
                    </p>
                </div>
            @endforelse
        </div>
    @endif

</div>
