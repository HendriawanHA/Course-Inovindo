<div
    x-data="{
        focusInput() {
            this.$nextTick(() => {
                const input = $refs.paletteInput;
                if (input) { input.focus(); input.select(); }
            });
        }
    }"
    x-on:open-command-palette.window="
        $wire.openPalette();
        $nextTick(() => focusInput());
    "
    x-on:keydown.escape.window="if ($wire.get('open')) { $wire.closePalette(); }"
    x-cloak
>
    {{-- Overlay --}}
    <div
        x-show="$wire.get('open')"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-start justify-center bg-zinc-950/60 px-4 pt-[15vh] backdrop-blur-sm"
        x-on:click.self="$wire.closePalette()"
    >
        {{-- Card --}}
        <div
            x-show="$wire.get('open')"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="w-full max-w-xl overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-2xl dark:border-zinc-700 dark:bg-zinc-900"
            @click.outside="$wire.closePalette()"
        >
            {{-- Search Input --}}
            <div class="flex items-center gap-3 border-b border-zinc-200 px-5 dark:border-zinc-700">
                <flux:icon.magnifying-glass class="size-5 shrink-0 text-zinc-400" />
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    x-ref="paletteInput"
                    placeholder="Search courses, students, discussions…"
                    class="h-14 flex-1 bg-transparent text-sm text-zinc-900 placeholder:text-zinc-400 focus:outline-none dark:text-white dark:placeholder:text-zinc-500"
                    x-on:keydown.escape="$wire.closePalette()"
                >
                <kbd class="hidden shrink-0 rounded-lg border border-zinc-300 px-1.5 py-0.5 text-[10px] font-medium text-zinc-400 dark:border-zinc-600 sm:inline">ESC</kbd>
            </div>

            {{-- Results --}}
            <div class="max-h-[50vh] overflow-y-auto p-2">

                {{-- Loading --}}
                <div wire:loading.flex wire:target="search" class="items-center gap-2 px-4 py-8 text-sm text-zinc-500 dark:text-zinc-400">
                    <svg class="size-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    Searching…
                </div>

                {{-- Empty State --}}
                @if (trim($search) !== '' && !$this->courses->count() && !$this->students->count() && !$this->discussions->count())
                    <div class="px-4 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                        No results for "<span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $search }}</span>".
                    </div>
                @endif

                {{-- Courses --}}
                @if ($this->courses->count())
                    <div class="mb-2">
                        <p class="px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Courses</p>
                        @foreach ($this->courses as $course)
                            <a href="{{ route('instructor.courses.edit', $course) }}"
                               class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-zinc-100 dark:hover:bg-zinc-800"
                               x-on:click="$wire.closePalette()">
                                <div class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                                    <flux:icon.book-open class="size-4" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-zinc-900 dark:text-white">{{ $course->title }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $course->lessons_count }} lesson{{ $course->lessons_count !== 1 ? 's' : '' }}</p>
                                </div>
                                <span class="shrink-0 rounded-full px-2 py-0.5 text-[11px] font-medium {{ $course->is_published ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-amber-500/10 text-amber-600 dark:text-amber-400' }}">
                                    {{ $course->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Students --}}
                @if ($this->students->count())
                    <div class="mb-2">
                        <p class="px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Students</p>
                        @foreach ($this->students as $enrollment)
                            <div class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-zinc-100 dark:hover:bg-zinc-800">
                                <img
                                    src="{{ $enrollment->user->avatar ? asset('storage/' . $enrollment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($enrollment->user->name) . '&background=6366f1&color=fff' }}"
                                    class="size-9 shrink-0 rounded-full object-cover"
                                >
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-zinc-900 dark:text-white">{{ $enrollment->user->name }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $enrollment->user->email }}</p>
                                </div>
                                <span class="shrink-0 text-xs text-zinc-400 dark:text-zinc-500">{{ $enrollment->course->title }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Discussions --}}
                @if ($this->discussions->count())
                    <div class="mb-2">
                        <p class="px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Discussions</p>
                        @foreach ($this->discussions as $discussion)
                            <a href="{{ route('instructor.courses.discussions', $discussion->course_id) }}"
                               class="flex items-start gap-3 rounded-xl px-3 py-2.5 transition hover:bg-zinc-100 dark:hover:bg-zinc-800"
                               x-on:click="$wire.closePalette()">
                                <div class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                    <flux:icon.chat-bubble-left class="size-4" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="line-clamp-1 text-sm text-zinc-900 dark:text-white">{{ $discussion->content }}</p>
                                    <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $discussion->user->name }} in {{ $discussion->course->title }}
                                        @if ($discussion->lesson) · {{ $discussion->lesson->title }} @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="flex items-center gap-4 border-t border-zinc-200 px-5 py-3 text-xs text-zinc-400 dark:border-zinc-700 dark:text-zinc-500">
                <span class="flex items-center gap-1"><kbd class="rounded border border-zinc-300 px-1 py-0.5 dark:border-zinc-600">↑↓</kbd> Navigate</span>
                <span class="flex items-center gap-1"><kbd class="rounded border border-zinc-300 px-1 py-0.5 dark:border-zinc-600">↵</kbd> Open</span>
                <span class="flex items-center gap-1"><kbd class="rounded border border-zinc-300 px-1 py-0.5 dark:border-zinc-600">esc</kbd> Close</span>
            </div>
        </div>
    </div>
</div>
