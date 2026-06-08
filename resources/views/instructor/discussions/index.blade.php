<x-layouts.instructor title="Course Discussions">
    @php
        $activeCourse = $course ?? null;
        $latestCourseId = $courses->first()?->id;
        $search = $search ?? '';
    @endphp

    <div class="py-4 pb-36 sm:py-8 sm:pb-40">
        <div class="mx-auto max-w-6xl space-y-6">

            <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white sm:text-3xl">
                        {{ $activeCourse?->title ?? 'Course Discussions' }}
                    </h1>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        Kelola diskusi student berdasarkan course dan balas dalam format thread.
                    </p>
                </div>

                @if ($activeCourse)
                    <div class="rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <span class="text-zinc-500 dark:text-zinc-400">Aktivitas terakhir</span>
                        <span class="ml-2 font-semibold text-zinc-900 dark:text-white">
                            {{ $activeCourse->latest_activity_at ? \Carbon\Carbon::parse($activeCourse->latest_activity_at)->diffForHumans() : '-' }}
                        </span>
                    </div>
                @endif
            </div>

            @if ($courses->isNotEmpty())
                <div class="-mx-4 overflow-x-auto px-4 pb-1 sm:mx-0 sm:px-0">
                    <div class="flex min-w-max gap-2">
                        @foreach ($courses as $c)
                            @php
                                $isActive = $activeCourse?->id === $c->id;
                                $isLatest = $latestCourseId === $c->id && $c->discussions_count > 0;
                            @endphp

                            <a href="{{ route('instructor.courses.discussions', $c) }}"
                                class="group inline-flex items-center gap-2 rounded-2xl border px-4 py-3 text-sm font-semibold transition
                                    {{ $isActive ? 'border-indigo-500 bg-indigo-600 text-white shadow-sm shadow-indigo-500/20' : 'border-zinc-200 bg-white text-zinc-600 hover:border-indigo-300 hover:text-indigo-600 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:border-indigo-500/50 dark:hover:text-white' }}">
                                <span class="max-w-44 truncate">{{ $c->title }}</span>

                                @if ($c->discussions_count > 0)
                                    <span class="rounded-full px-2 py-0.5 text-[11px] tabular-nums {{ $isActive ? 'bg-white/20 text-white' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                        {{ $c->discussions_count }}
                                    </span>
                                @endif

                                @if ($isLatest)
                                    <span class="rounded-full px-2 py-0.5 text-[11px] font-bold {{ $isActive ? 'bg-amber-300 text-amber-950' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300' }}">
                                        Terbaru
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($activeCourse)
                <div class="space-y-2">
                    <x-instructor.search-input
                        :livewire="false"
                        :action="route('instructor.courses.discussions', $activeCourse)"
                        :clear-url="route('instructor.courses.discussions', $activeCourse)"
                        :value="$search"
                        placeholder="Cari diskusi, student, atau lesson..." />

                    @if ($search !== '')
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            Menampilkan {{ $discussions->total() }} hasil untuk "{{ $search }}".
                        </p>
                    @endif
                </div>
            @endif

            <div class="grid gap-3 sm:grid-cols-3">
                <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Diskusi</p>
                    <p class="mt-1 text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalDiscussions }}</p>
                </div>
                <div class="rounded-3xl border border-amber-200 bg-amber-50 p-5 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/10">
                    <p class="text-sm text-amber-700 dark:text-amber-300">Belum Dibalas</p>
                    <p class="mt-1 text-2xl font-bold text-amber-800 dark:text-amber-200">{{ $unansweredDiscussions }}</p>
                </div>
            </div>

            <section class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800 sm:px-6">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Thread Diskusi</h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        Pertanyaan student dan balasan instruktur ditampilkan dalam satu alur percakapan.
                    </p>
                </div>

                <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($discussions as $discussion)
                        @php
                            $replies = $discussion->replies->sortBy('created_at');
                            $hasInstructorReply = $replies->contains(fn($r) => $r->user->role === 'instructor');
                            $isUnanswered = ! $hasInstructorReply;
                            $lastReply = $replies->sortByDesc('created_at')->first();
                            $lastActivityAt = $lastReply?->created_at ?? $discussion->created_at;
                        @endphp

                        <article class="px-5 py-5 sm:px-6">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="font-semibold text-zinc-900 dark:text-white">
                                            {{ $discussion->lesson?->title ?? 'Diskusi Course' }}
                                        </h3>
                                        @if ($isUnanswered)
                                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">Belum dibalas</span>
                                        @else
                                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">Sudah dibalas</span>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                        Aktivitas terakhir {{ $lastActivityAt->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 space-y-4">
                                <div class="flex gap-3 sm:gap-4">
                                    <img src="{{ $discussion->user->avatar ? asset('storage/' . $discussion->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}"
                                        alt="{{ $discussion->user->name }}"
                                        class="size-10 shrink-0 rounded-full object-cover sm:size-11">

                                    <div class="min-w-0 flex-1 rounded-2xl bg-zinc-50 p-4 dark:bg-zinc-950/60">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $discussion->user->name }}</p>
                                            <span class="rounded-full bg-zinc-200 px-2 py-0.5 text-[11px] font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">Student</span>
                                            <span class="text-xs text-zinc-400">{{ $discussion->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-zinc-700 dark:text-zinc-300">{{ $discussion->content }}</p>
                                        <button type="button"
                                            data-discussion-id="{{ $discussion->id }}"
                                            data-reply-name="{{ $discussion->user->name }}"
                                            class="js-reply-button mt-3 inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold text-zinc-500 transition hover:bg-zinc-200 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white">
                                            <flux:icon.chat-bubble-left class="size-4" />
                                            Balas
                                        </button>
                                    </div>
                                </div>

                                @foreach ($replies as $reply)
                                    <div class="flex gap-3 pl-6 sm:gap-4 sm:pl-12">
                                        <img src="{{ $reply->user->avatar ? asset('storage/' . $reply->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) }}"
                                            alt="{{ $reply->user->name }}"
                                            class="size-9 shrink-0 rounded-full object-cover">

                                        <div class="min-w-0 flex-1 rounded-2xl border border-zinc-200 p-4 dark:border-zinc-800">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $reply->user->name }}</p>
                                                @if ($reply->user->role === 'instructor')
                                                    <span class="rounded-full bg-indigo-100 px-2 py-0.5 text-[11px] font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">Instructor</span>
                                                @else
                                                    <span class="rounded-full bg-zinc-100 px-2 py-0.5 text-[11px] font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">Student</span>
                                                @endif
                                                <span class="text-xs text-zinc-400">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">{{ $reply->content }}</p>
                                            <button type="button"
                                                data-discussion-id="{{ $discussion->id }}"
                                                data-reply-name="{{ $reply->user->name }}"
                                                class="js-reply-button mt-3 inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white">
                                                <flux:icon.chat-bubble-left class="size-4" />
                                                Balas
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @empty
                        <div class="px-6 py-14 text-center">
                            <h3 class="font-semibold text-zinc-900 dark:text-white">Belum ada diskusi</h3>
                            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                                Diskusi dari student untuk course ini akan muncul di sini.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            @if ($discussions->hasPages())
                <div>
                    {{ $discussions->links() }}
                </div>
            @endif

        </div>

        <div id="reply-composer" class="sticky bottom-4 z-20 mx-auto mt-8 hidden max-w-6xl px-0">
            <form method="POST" action="{{ route('instructor.discussions.reply.store') }}" class="rounded-3xl bg-white/80 p-0.5 shadow-2xl backdrop-blur dark:bg-zinc-950/80">
                @csrf
                <input id="reply-discussion-id" type="hidden" name="discussion_id" value="">

                <div class="rounded-3xl border border-zinc-200 bg-white p-3 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 sm:p-4">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <div class="min-w-0 text-xs text-zinc-500 dark:text-zinc-400">
                            Membalas
                            <span id="reply-mention-label" class="font-semibold text-indigo-600 dark:text-indigo-300"></span>
                        </div>
                        <button type="button"
                            id="reply-cancel-button"
                            class="rounded-full p-1.5 text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-700 dark:hover:bg-zinc-800 dark:hover:text-zinc-200"
                            aria-label="Batal membalas">
                            <flux:icon.x-mark class="size-4" />
                        </button>
                    </div>

                    <div class="flex items-start gap-3">
                        <img
                            src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                            alt="{{ auth()->user()->name }}"
                            class="size-10 rounded-full object-cover ring-1 ring-zinc-200 dark:ring-zinc-700">

                        <div class="min-w-0 flex-1">
                            <textarea
                                id="reply-content"
                                name="content"
                                rows="1"
                                required
                                placeholder="Tulis balasan..."
                                class="max-h-40 min-h-11 w-full resize-none border-0 bg-transparent px-0 py-2 text-sm leading-relaxed text-zinc-900 placeholder:text-zinc-400 focus:ring-0 dark:text-white"></textarea>

                            <div class="mt-2 flex items-center justify-end  gap-3">
                                <button type="submit"
                                    id="reply-submit-button"
                                    disabled
                                    class="rounded-full bg-indigo-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:bg-zinc-200 disabled:text-zinc-400 dark:disabled:bg-zinc-800 dark:disabled:text-zinc-500">
                                    Balas
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const composer = document.getElementById('reply-composer');
            const discussionInput = document.getElementById('reply-discussion-id');
            const mentionLabel = document.getElementById('reply-mention-label');
            const textarea = document.getElementById('reply-content');
            const submitButton = document.getElementById('reply-submit-button');
            const cancelButton = document.getElementById('reply-cancel-button');

            if (!composer || !discussionInput || !mentionLabel || !textarea || !submitButton || !cancelButton) {
                return;
            }

            let mention = '';

            const resizeTextarea = () => {
                textarea.style.height = 'auto';
                textarea.style.height = `${textarea.scrollHeight}px`;
            };

            const syncSubmitState = () => {
                submitButton.disabled = !discussionInput.value || textarea.value.trim().length <= mention.length;
            };

            const openComposer = (button) => {
                const discussionId = button.dataset.discussionId;
                const name = button.dataset.replyName;

                if (!discussionId || !name) {
                    return;
                }

                mention = `@${name}`;
                discussionInput.value = discussionId;
                mentionLabel.textContent = mention;
                textarea.value = `${mention} `;
                composer.classList.remove('hidden');

                requestAnimationFrame(() => {
                    textarea.focus();
                    textarea.setSelectionRange(textarea.value.length, textarea.value.length);
                    resizeTextarea();
                    syncSubmitState();
                    composer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
            };

            const closeComposer = () => {
                mention = '';
                discussionInput.value = '';
                mentionLabel.textContent = '';
                textarea.value = '';
                submitButton.disabled = true;
                composer.classList.add('hidden');
                resizeTextarea();
            };

            document.querySelectorAll('.js-reply-button').forEach((button) => {
                button.addEventListener('click', () => openComposer(button));
            });

            textarea.addEventListener('input', () => {
                resizeTextarea();
                syncSubmitState();
            });

            cancelButton.addEventListener('click', closeComposer);

            textarea.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeComposer();
                    return;
                }

                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault();
                    if (!submitButton.disabled) {
                        submitButton.click();
                    }
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !composer.classList.contains('hidden')) {
                    closeComposer();
                }
            });
        });
    </script>
</x-layouts.instructor>
