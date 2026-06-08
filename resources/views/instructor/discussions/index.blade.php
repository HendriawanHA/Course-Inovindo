<x-layouts.instructor title="Course Discussions">
    @php
        $activeCourse = $course ?? null;
        $search = $search ?? '';
    @endphp

    <div class="py-4 pb-36 sm:py-8 sm:pb-40">
        <div class="mx-auto max-w-6xl space-y-6">

            <div class="space-y-3">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white sm:text-3xl">
                        Diskusi
                    </h1>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        Pantau pertanyaan student dan balas dari satu tempat.
                    </p>
                </div>

                @if ($activeCourse)
                    <div class="flex flex-wrap items-center gap-2 text-sm">
                        <span class="text-zinc-500 dark:text-zinc-400">Course aktif:</span>
                        <span class="max-w-full truncate rounded-lg bg-zinc-100 px-3 py-1 font-semibold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                            {{ $activeCourse->title }}
                        </span>
                        <span class="text-zinc-300 dark:text-zinc-700">/</span>
                        <span class="text-zinc-500 dark:text-zinc-400">{{ $totalDiscussions }} diskusi</span>
                        <span class="text-zinc-300 dark:text-zinc-700">/</span>
                        <span class="font-medium text-amber-700 dark:text-amber-300">
                            {{ $unansweredDiscussions }} belum dibalas
                        </span>
                    </div>
                @endif
            </div>

            <section class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
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
                        @endphp

                        <article class="px-5 py-5 sm:px-6">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="font-semibold text-zinc-900 dark:text-white">
                                            {{ $discussion->lesson?->title ?? 'Diskusi Course' }}
                                        </h3>
                                        @if ($isUnanswered)
                                            <span class="rounded-lg bg-amber-400/15 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:text-amber-300">Belum dibalas</span>
                                        @else
                                            <span class="rounded-lg bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">Sudah dibalas</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 space-y-4">
                                <div class="flex gap-3 sm:gap-4">
                                    <img src="{{ $discussion->user->avatar ? asset('storage/' . $discussion->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}"
                                        alt="{{ $discussion->user->name }}"
                                        class="size-10 shrink-0 rounded-full object-cover">

                                    <div class="min-w-0 flex-1 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-950/60">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $discussion->user->name }}</p>
                                            <span class="rounded-md bg-zinc-200 px-2 py-0.5 text-[11px] font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">Student</span>
                                            <span class="text-xs text-zinc-400">{{ $discussion->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-zinc-700 dark:text-zinc-300">{{ $discussion->content }}</p>
                                        <button type="button"
                                            data-discussion-id="{{ $discussion->id }}"
                                            data-reply-name="{{ $discussion->user->name }}"
                                            class="js-reply-button mt-3 inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-zinc-500 transition hover:bg-zinc-200 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white">
                                            <flux:icon.chat-bubble-left class="size-4" />
                                            Balas
                                        </button>
                                    </div>
                                </div>

                                @foreach ($replies as $reply)
                                    <div class="flex gap-3 pl-6 sm:gap-4 sm:pl-12">
                                        <img src="{{ $reply->user->avatar ? asset('storage/' . $reply->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) }}"
                                            alt="{{ $reply->user->name }}"
                                            class="size-10 shrink-0 rounded-full object-cover">

                                        <div class="min-w-0 flex-1 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-950/60">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $reply->user->name }}</p>
                                                @if ($reply->user->role === 'instructor')
                                                    <span class="rounded-md bg-indigo-100 px-2 py-0.5 text-[11px] font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">Instructor</span>
                                                @else
                                                    <span class="rounded-md bg-zinc-100 px-2 py-0.5 text-[11px] font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">Student</span>
                                                @endif
                                                <span class="text-xs text-zinc-400">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">{{ $reply->content }}</p>
                                            <button type="button"
                                                data-discussion-id="{{ $discussion->id }}"
                                                data-reply-name="{{ $reply->user->name }}"
                                                class="js-reply-button mt-3 inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white">
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

        <div id="reply-composer" class="fixed bottom-0 left-0 right-0 z-40 hidden px-4 sm:px-6 lg:left-72">
            <form method="POST" action="{{ route('instructor.discussions.reply.store') }}" class="mx-auto max-w-6xl rounded-t-xl bg-white/90 px-4 py-3 shadow-[0_-10px_30px_-18px_rgba(15,23,42,0.45)] backdrop-blur dark:bg-zinc-950/90 dark:shadow-[0_-10px_30px_-18px_rgba(0,0,0,0.85)] md:px-6 md:py-4">
                @csrf
                <input id="reply-discussion-id" type="hidden" name="discussion_id" value="">

                <div class="mb-3 flex items-center justify-between gap-3">
                    <div class="min-w-0 text-xs text-zinc-500 dark:text-zinc-400">
                        Membalas
                        <span id="reply-mention-label" class="font-semibold text-indigo-600 dark:text-indigo-300"></span>
                    </div>
                    <button type="button"
                        id="reply-cancel-button"
                        class="rounded-lg p-1.5 text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-700 dark:hover:bg-zinc-800 dark:hover:text-zinc-200"
                        aria-label="Batal membalas">
                        <flux:icon.x-mark class="size-4" />
                    </button>
                </div>

                <div class="flex items-end gap-3">
                    <div class="min-w-0 flex-1">
                        <textarea
                            id="reply-content"
                            name="content"
                            rows="1"
                            required
                            placeholder="Tulis balasan..."
                            class="max-h-40 min-h-11 w-full resize-none border-0 bg-transparent py-3 text-sm leading-relaxed text-zinc-900 outline-none placeholder:text-zinc-400 focus:border-0 focus:outline-none focus:ring-0 dark:text-white dark:placeholder:text-zinc-500"></textarea>
                    </div>
                    <button type="submit"
                        id="reply-submit-button"
                        disabled
                        class="mb-0.5 shrink-0 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:bg-zinc-200 disabled:text-zinc-400 dark:disabled:bg-zinc-800 dark:disabled:text-zinc-500">
                        Balas
                    </button>
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
