<div id="discussion-section"
    class="border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden">

    <div class="px-6 py-5 border-zinc-200 dark:border-zinc-800">
        <flux:heading size="lg" class="text-zinc-900 dark:text-white">
            Discussion
        </flux:heading>

        <flux:text class="mt-1 text-zinc-500 dark:text-zinc-400">
            Share thoughts, ask questions, or discuss this lesson.
        </flux:text>
    </div>

    <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
        @forelse ($discussions as $discussion)
        <div class="p-5">
            <div class="flex gap-4">
                <img
                    src="{{ $discussion->user->avatar
                            ? asset('storage/' . $discussion->user->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}"
                    class="w-10 h-10 rounded-full object-cover shrink-0">

                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <h4 class="font-semibold text-zinc-900 dark:text-white">
                            {{ $discussion->user->name }}
                        </h4>

                        @if ($discussion->user->role === 'instructor')
                        <span
                            class="px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                            Instructor
                        </span>
                        @endif

                        <span class="text-xs text-zinc-400">
                            {{ $discussion->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                        {{ $discussion->content }}
                    </p>

                    <button
                        type="button"
                        wire:click="startReply({{ $discussion->id }}, '{{ addslashes($discussion->user->name) }}')"
                        class="mt-3 text-sm text-indigo-500 hover:text-indigo-700">
                        Reply
                    </button>

                    @if ($discussion->replies->count())
                    <div class="mt-5 space-y-4 border-l-2 border-zinc-200 dark:border-zinc-800 pl-4">
                        @foreach ($discussion->replies as $reply)
                        <div class="flex gap-3">
                            <img
                                src="{{ $reply->user->avatar
                                                ? asset('storage/' . $reply->user->avatar)
                                                : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) }}"
                                class="w-8 h-8 rounded-full object-cover shrink-0">

                            <div class="flex-1 rounded-2xl bg-zinc-50 dark:bg-zinc-800/60 px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <h5 class="text-sm font-semibold text-zinc-900 dark:text-white">
                                        {{ $reply->user->name }}
                                    </h5>

                                    @if ($reply->user->role === 'instructor')
                                    <span
                                        class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                                        Instructor
                                    </span>
                                    @endif

                                    <span class="text-xs text-zinc-400">
                                        {{ $reply->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <p class="mt-1 text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    {{ $reply->content }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center text-center px-8 py-14">
            <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 flex items-center justify-center mb-5">
                <flux:icon.chat-bubble-left-right class="w-8 h-8 text-indigo-500" />
            </div>

            <h3 class="font-semibold text-zinc-900 dark:text-white">
                No discussions yet
            </h3>

            <p class="mt-2 text-sm leading-relaxed text-zinc-500 dark:text-zinc-400 max-w-xs">
                Start the first discussion, ask a question, or share your thoughts.
            </p>
        </div>
        @endforelse
    </div>

    <form wire:submit.prevent="send" class="p-4 border-t border-zinc-200 dark:border-zinc-800">

        @if ($replyingTo)
        <div
            class="mb-3 flex items-center justify-between rounded-xl bg-indigo-50 dark:bg-indigo-500/10 px-4 py-2 text-sm">
            <span class="text-indigo-700 dark:text-indigo-300">
                Replying to <strong>{{ $replyingName }}</strong>
            </span>

            <button type="button" wire:click="cancelReply" class="text-indigo-500 hover:text-indigo-700">
                Cancel
            </button>
        </div>
        @endif

        <div class="flex items-end gap-3">
            <textarea
                wire:model="content"
                rows="1"
                required
                placeholder="Write a comment..."
                oninput="this.style.height = 'auto'; this.style.height = this.scrollHeight + 'px'"
                class="min-h-[48px] max-h-40 flex-1 resize-none rounded-2xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-950 px-4 py-3 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none overflow-hidden"></textarea>

            <button type="submit"
                class="inline-flex h-[48px] items-center justify-center rounded-2xl bg-indigo-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 active:scale-95">
                {{ $replyingTo ? 'Reply' : 'Send' }}
            </button>
        </div>

        @error('content')
        <p class="mt-2 text-sm text-red-500">
            {{ $message }}
        </p>
        @enderror
    </form>
</div>