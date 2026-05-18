<x-app-layout>
    <div class="flex flex-1">

        <!-- Main Content -->
        <div class="flex flex-col w-full pt-5 bg-zinc-50 dark:bg-zinc-950 min-h-screen">

            <!-- Header -->
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
                    <flux:navbar.item>
                        <flux:icon.chat-bubble-bottom-center-text />
                    </flux:navbar.item>
                    <flux:navbar.item>
                        <flux:icon.list-bullet />
                    </flux:navbar.item>
                    <flux:navbar.item>
                        <flux:icon.bookmark />
                    </flux:navbar.item>
                </div>
            </div>

            <flux:separator />

            <!-- Konten Utama -->
            <div class="max-w-4xl mx-auto w-full px-6 mt-8">

                <!-- Lesson Info + Navigation -->
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
                        {{-- PREVIOUS --}}
                        @if ($previousLesson)
                            <a href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $previousLesson->id]) }}">
                                <flux:button icon="arrow-left" variant="ghost" class="border border-zinc-300 dark:border-zinc-700">
                                </flux:button>
                            </a>
                        @else
                            <flux:button icon="arrow-left" variant="subtle" disabled 
                                class="border border-zinc-300 dark:border-zinc-700 opacity-40 cursor-not-allowed">
                            </flux:button>
                        @endif

                        {{-- NEXT --}}
                        @if ($nextLesson)
                            <a href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $nextLesson->id]) }}">
                                <flux:button icon="arrow-right" variant="ghost" class="border border-zinc-300 dark:border-zinc-700">
                                </flux:button>
                            </a>
                        @else
                            <flux:button icon="arrow-right" variant="subtle" disabled 
                                class="border border-zinc-300 dark:border-zinc-700 opacity-40 cursor-not-allowed">
                            </flux:button>
                        @endif
                    </div>
                </div>

                <!-- Video Container -->
                <div class="w-full rounded-3xl overflow-hidden border border-zinc-200 dark:border-zinc-800 
                            bg-white dark:bg-zinc-900 shadow-xl">
                    <iframe
                        width="100%"
                        height="450"
                        src="{{ $lesson->youtube_embed_url }}"
                        frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>

            </div>

            <flux:separator class="my-10" />

            <!-- Complete Button -->
            <div class="flex justify-center mb-8">
                <flux:button variant="filled" icon-trailing="arrow-right" class="px-10 py-6 text-base">
                    Complete Lesson
                </flux:button>
            </div>

        </div>

        <!-- Sidebar -->
        <flux:sidebar sticky class="w-80 h-screen border-l border-zinc-200 dark:border-zinc-800 
                                  bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white 
                                  p-5 overflow-y-auto">

            <flux:heading size="lg" class="mb-6 text-zinc-900 dark:text-white">
                Course Content
            </flux:heading>

            <div class="border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden divide-y divide-zinc-200 dark:divide-zinc-800">

                @foreach ($course->modules as $module)
                <div x-data="{ open: true }" class="bg-white dark:bg-zinc-900">

                    <!-- Module Header -->
                    <button
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

                    <!-- Lesson List -->
                    <div
                        x-show="open"
                        x-transition
                        class="divide-y divide-zinc-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">

                        @foreach ($module->lessons as $lesson)
                        <a
                            href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $lesson->id]) }}"
                            class="p-4 flex items-center gap-3 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors
                            {{ request()->route('lesson') == $lesson->id ? 'bg-zinc-100 dark:bg-zinc-800' : '' }}">

                            <input
                                type="checkbox"
                                name="lesson"
                                class="accent-indigo-600 dark:accent-indigo-500"
                                {{ request()->route('lesson') == $lesson->id ? 'checked' : '' }}>

                            <span class="text-sm text-zinc-700 dark:text-zinc-200">
                                {{ $lesson->title }}
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