<x-app-layout>
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex flex-1">

        <div class="flex-1 flex flex-col pt-5 bg-zinc-50 dark:bg-zinc-950 min-h-screen">

            <div class="flex justify-between items-center gap-2 text-zinc-500 dark:text-zinc-400 px-6 mb-6">
                <div class="flex items-center gap-3">
                    <flux:navbar.item href="{{ route('courses.show', $course->id) }}">
                        <flux:icon.arrow-left variant="micro" />
                    </flux:navbar.item>

                    <flux:heading size="xl" class="dark:text-white text-zinc-900">
                        {{ $course->title }}
                    </flux:heading>
                </div>

                <div class="flex items-center gap-1 mr-5">
                    <flux:navbar.item
                        @click="document.getElementById('discussion-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' })"
                        class="relative cursor-pointer">
                        <flux:icon.chat-bubble-bottom-center-text class="w-5 h-5" />
                        <div class="absolute top-1 right-1 w-2 h-2 rounded-full bg-indigo-500"></div>
                    </flux:navbar.item>

                    <flux:navbar.item @click="sidebarOpen = !sidebarOpen" class="cursor-pointer">
                        <flux:icon.list-bullet
                            class="transition-all duration-200"
                            x-bind:class="sidebarOpen
                                ? 'text-indigo-500'
                                : 'text-zinc-500 dark:text-zinc-400'" />
                    </flux:navbar.item>

                    <div x-data="{ bookmarked: false }">
                        <flux:navbar.item @click="bookmarked = !bookmarked"
                            class="cursor-pointer transition-all duration-200">
                            <flux:icon.bookmark
                                class="transition-all duration-200"
                                x-bind:class="bookmarked
                                    ? 'text-blue-500 fill-blue-500 scale-110'
                                    : 'text-zinc-500 dark:text-zinc-400'" />
                        </flux:navbar.item>
                    </div>
                </div>
            </div>

            <flux:separator />

            <div class="max-w-4xl mx-auto w-full px-6 mt-8">

                <div class="flex items-center justify-between mb-8">
                    <div>
                        <flux:text class="text-zinc-500 dark:text-zinc-400">
                            Lesson {{ $currentLessonIndex + 1 }} of {{ $totalLessons }}
                        </flux:text>

                        <flux:heading size="xl" class="mt-2 text-zinc-900 dark:text-white">
                            {{ $lesson->title }}
                        </flux:heading>
                    </div>

                    <div class="flex items-center gap-4">
                        @if ($previousLesson)
                            <a wire:navigate
                                href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $previousLesson->id]) }}">
                                <flux:button icon="arrow-left" variant="ghost"
                                    class="border border-zinc-300 dark:border-zinc-700" />
                            </a>
                        @else
                            <flux:button icon="arrow-left" variant="subtle" disabled
                                class="border border-zinc-300 dark:border-zinc-700 opacity-40 cursor-not-allowed" />
                        @endif

                        @if ($nextLesson)
                            <a wire:navigate
                                href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $nextLesson->id]) }}">
                                <flux:button icon="arrow-right" variant="ghost"
                                    class="border border-zinc-300 dark:border-zinc-700" />
                            </a>
                        @else
                            <flux:button icon="arrow-right" variant="subtle" disabled
                                class="border border-zinc-300 dark:border-zinc-700 opacity-40 cursor-not-allowed" />
                        @endif
                    </div>
                </div>

                <div
                    class="w-full rounded-3xl overflow-hidden border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-xl">
                    <iframe
                        width="100%"
                        height="450"
                        src="{{ $lesson->youtube_embed_url }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>

                <div id="discussion-section"
                    x-data="{
                        replyingTo: null,
                        replyingName: null,
                        replyUrl: null,
                        setReply(id, name, url) {
                            this.replyingTo = id
                            this.replyingName = name
                            this.replyUrl = url
                            this.$nextTick(() => this.$refs.commentInput.focus())
                        },
                        cancelReply() {
                            this.replyingTo = null
                            this.replyingName = null
                            this.replyUrl = null
                        }
                    }"
                    class="mt-10 rounded-3xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden">

                    <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800">
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
                                            @click="setReply({{ $discussion->id }}, '{{ addslashes($discussion->user->name) }}', '{{ route('discussions.reply', $discussion->id) }}')"
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

                    <form method="POST"
                        x-bind:action="replyUrl ?? '{{ route('discussions.store') }}'"
                        class="p-4 border-t border-zinc-200 dark:border-zinc-800">

                        @csrf

                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

                        <div x-show="replyingTo" x-transition
                            class="mb-3 flex items-center justify-between rounded-xl bg-indigo-50 dark:bg-indigo-500/10 px-4 py-2 text-sm">
                            <span class="text-indigo-700 dark:text-indigo-300">
                                Replying to <strong x-text="replyingName"></strong>
                            </span>

                            <button type="button" @click="cancelReply()" class="text-indigo-500 hover:text-indigo-700">
                                Cancel
                            </button>
                        </div>

                        <div class="flex items-end gap-3">
                            <textarea
                                x-ref="commentInput"
                                name="content"
                                rows="1"
                                required
                                placeholder="Write a comment..."
                                oninput="this.style.height = 'auto'; this.style.height = this.scrollHeight + 'px'"
                                class="min-h-[48px] max-h-40 flex-1 resize-none rounded-2xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-950 px-4 py-3 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none overflow-hidden"></textarea>

                            <button type="submit"
                                class="inline-flex h-[48px] items-center justify-center rounded-2xl bg-indigo-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 active:scale-95">
                                <span x-text="replyingTo ? 'Reply' : 'Send'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <flux:separator class="my-10" />

            <div class="flex justify-center mb-8">
                @php
                    $completed = auth()->user()?->completedLessons?->contains($lesson->id);
                @endphp

                @if ($completed)
                    <flux:button color="emerald" variant="filled" class="px-10 py-6 text-base">
                        Completed
                    </flux:button>
                @else
                    <form
                        method="POST"
                        action="{{ route('lessons.complete', [
                            'course' => $course->id,
                            'lesson' => $lesson->id,
                        ]) }}">
                        @csrf

                        <flux:button
                            type="submit"
                            variant="filled"
                            icon-trailing="arrow-right"
                            class="px-10 py-6 text-base">
                            Complete Lesson
                        </flux:button>
                    </form>
                @endif
            </div>
        </div>

        <flux:sidebar
            sticky
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            class="w-80 h-screen border-l border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white p-5 overflow-y-auto">

            <flux:heading size="lg" class="mb-6 text-zinc-900 dark:text-white">
                Course Content
            </flux:heading>

            <div class="border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden divide-y divide-zinc-200 dark:divide-zinc-800">
                @foreach ($course->modules as $module)
                    <div x-data="{ open: true }" class="bg-white dark:bg-zinc-900">
                        <button
                            type="button"
                            @click="open = !open"
                            class="w-full flex items-center justify-between p-4 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-left">

                            <div class="flex items-center gap-3">
                                <flux:icon.chevron-right
                                    variant="micro"
                                    class="transition-transform duration-300 text-zinc-400"
                                    x-bind:class="open ? 'rotate-90' : ''" />

                                <div>
                                    <p class="font-semibold text-zinc-900 dark:text-white">
                                        {{ $module->title }}
                                    </p>

                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $module->lessons->count() }} lessons
                                    </p>
                                </div>
                            </div>
                        </button>

                        <div
                            x-show="open"
                            x-transition
                            class="divide-y divide-zinc-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">

                            @foreach ($module->lessons as $moduleLesson)
                                @php
                                    $isCompleted = auth()->user()?->completedLessons?->contains($moduleLesson->id);
                                    $isActive = (int) request()->route('lesson') === (int) $moduleLesson->id;
                                @endphp

                                <a wire:navigate
                                    href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $moduleLesson->id]) }}"
                                    class="p-4 flex items-center gap-3 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors {{ $isActive ? 'bg-zinc-100 dark:bg-zinc-800' : '' }}">

                                    <input
                                        type="checkbox"
                                        disabled
                                        class="accent-indigo-600 dark:accent-indigo-500"
                                        {{ $isCompleted ? 'checked' : '' }}>

                                    <span class="text-sm text-zinc-700 dark:text-zinc-200">
                                        {{ $moduleLesson->title }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </flux:sidebar>
    </div>
</x-app-layout>
