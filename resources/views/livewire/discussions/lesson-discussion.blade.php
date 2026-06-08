<div x-data="{
    showComposer: false,
    composerStyle: '',
    _rafId: null,
    init() {
        this.$nextTick(() => {
            const sentinel = this.$el.querySelector('[data-sentinel]');
            if (sentinel) {
                new IntersectionObserver(
                    ([entry]) => {
                        this.showComposer = entry.isIntersecting;
                        if (entry.isIntersecting) {
                            this._startSync();
                        } else {
                            this._stopSync();
                        }
                    },
                    { threshold: 0 }
                ).observe(sentinel);
            }

            const el = document.querySelector('[data-iframe-width]') ?? document.querySelector('[data-video-width]') ?? this.$el.closest('[data-content-area]');
            if (el) {
                new ResizeObserver(() => this._updateWidth()).observe(el);
            }
        });
    },
    _startSync() {
        this._stopSync();
        this._updateWidth();
        const tick = () => {
            if (!this.showComposer) return;
            this._updateWidth();
            this._rafId = requestAnimationFrame(tick);
        };
        this._rafId = requestAnimationFrame(tick);
    },
    _stopSync() {
        if (this._rafId) {
            cancelAnimationFrame(this._rafId);
            this._rafId = null;
        }
    },
    _updateWidth() {
        const el = document.querySelector('[data-iframe-width]') ?? document.querySelector('[data-video-width]') ?? this.$el.closest('[data-content-area]');
        if (!el) return;
        const r = el.getBoundingClientRect();
        const s = `left: ${r.left}px; width: ${r.width}px;`;
        if (s === this.composerStyle) return;
        const m = this.composerStyle.match(/left: ([\d.]+)px; width: ([\d.]+)px;/);
        if (m && Math.abs(r.left - parseFloat(m[1])) < 0.5 && Math.abs(r.width - parseFloat(m[2])) < 0.5) return;
        this.composerStyle = s;
    }
}">
    <div class="border-b border-zinc-200 py-4 dark:border-zinc-800">
        <div class="mx-auto w-full max-w-4xl px-4 md:px-6">
            <h2 class="font-semibold text-zinc-900 dark:text-white">Diskusi</h2>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                Tanya dan diskusi dengan instruktur seputar lesson ini.
            </p>
        </div>
    </div>

    <div class="h-px"></div>

    <div class="mx-auto w-full max-w-4xl">
        <div data-sentinel class="divide-y divide-zinc-200 dark:divide-zinc-800">
        @forelse ($discussions as $discussion)
            @php
                $replies = $discussion->replies->sortBy('created_at');
            @endphp

            <article class="px-5 py-5 sm:px-6">
                <div class="space-y-4">
                    <div class="flex gap-3 sm:gap-4">
                        <img src="{{ $discussion->user->avatar ? asset('storage/' . $discussion->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}"
                            alt="{{ $discussion->user->name }}"
                            class="size-10 shrink-0 rounded-full object-cover">

                        <div class="min-w-0 flex-1 rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-950/60">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $discussion->user->name }}</p>
                                <span class="rounded-full bg-zinc-200 px-2 py-0.5 text-[11px] font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">Student</span>
                                <span class="text-xs text-zinc-400">{{ $discussion->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-zinc-700 dark:text-zinc-300">{{ $discussion->content }}</p>
                            <button type="button"
                                wire:click="startReply({{ $discussion->id }}, '{{ addslashes($discussion->user->name) }}')"
                                class="mt-3 inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold text-zinc-500 transition hover:bg-zinc-200 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white">
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

                            <div class="min-w-0 flex-1 rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-950/60">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $reply->user->name }}</p>
                                    @if ($reply->user->role === 'instructor')
                                        <span class="rounded-full bg-indigo-100 px-2 py-0.5 text-[11px] font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">Instruktur</span>
                                    @else
                                        <span class="rounded-full bg-zinc-100 px-2 py-0.5 text-[11px] font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">Student</span>
                                    @endif
                                    <span class="text-xs text-zinc-400">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">{{ $reply->content }}</p>
                                <button type="button"
                                    wire:click="startReply({{ $discussion->id }}, '{{ addslashes($reply->user->name) }}')"
                                    class="mt-3 inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold text-zinc-500 transition hover:bg-zinc-200 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white">
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
                <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-indigo-500/10">
                    <flux:icon.chat-bubble-left-right class="size-8 text-indigo-500" />
                </div>
                <h3 class="mt-5 font-semibold text-zinc-900 dark:text-white">Belum ada diskusi</h3>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                    Mulai diskusi dengan menulis pertanyaan di bawah.
                </p>
            </div>
        @endforelse
        </div>
    </div>

    <div x-show="showComposer" class="h-36"></div>

    <div x-show="showComposer"
        :style="composerStyle"
        x-transition:enter.duration.200ms
        class="fixed bottom-0 z-50 rounded-t-2xl bg-white/90 px-4 py-3 shadow-[0_-10px_30px_-18px_rgba(15,23,42,0.45)] backdrop-blur dark:bg-zinc-950/90 dark:shadow-[0_-10px_30px_-18px_rgba(0,0,0,0.85)] md:px-6 md:py-4">
        <form wire:submit.prevent="send">
            @csrf

            @if ($replyingTo)
                <div class="mb-3 flex items-center justify-between gap-3">
                    <div class="min-w-0 text-xs text-zinc-500 dark:text-zinc-400">
                        Membalas
                        <span class="font-semibold text-indigo-600 dark:text-indigo-300">{{ '@' . $replyingName }}</span>
                    </div>
                    <button type="button"
                        wire:click="cancelReply"
                        class="rounded-full p-1.5 text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-700 dark:hover:bg-zinc-800 dark:hover:text-zinc-200"
                        aria-label="Batal membalas">
                        <flux:icon.x-mark class="size-4" />
                    </button>
                </div>
            @endif

            <div class="flex items-end gap-3">
                <div class="min-w-0 flex-1">
                    <textarea
                        wire:model="content"
                        x-on:keydown.enter="if (!$event.shiftKey) { $event.preventDefault(); $wire.send(); $el.style.height = 'auto' }"
                        x-on:focus-reply-input.window="showComposer = true; $nextTick(() => $el.focus())"
                        x-on:input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                        rows="1"
                        required
                        placeholder="Tulis pertanyaan atau balasan..."
                        class="max-h-40 min-h-11 w-full resize-none border-0 bg-transparent py-3 text-sm leading-relaxed text-zinc-900 outline-none placeholder:text-zinc-400 focus:border-0 focus:outline-none focus:ring-0 dark:text-white dark:placeholder:text-zinc-500"></textarea>

                </div>
                <button type="submit"
                    class="mb-0.5 shrink-0 rounded-full bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    {{ $replyingTo ? 'Balas' : 'Kirim' }}
                </button>
            </div>
        </form>
    </div>
</div>
