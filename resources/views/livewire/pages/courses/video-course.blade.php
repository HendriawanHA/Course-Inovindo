<x-app-layout>

    <div
        x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
        class="flex flex-1">

        <!-- Main Content -->
        <div class="flex-1 flex flex-col pt-5 bg-zinc-50 dark:bg-zinc-950 min-h-screen">

            <!-- Header -->
            <div class="flex justify-between items-center gap-2 text-zinc-500 dark:text-zinc-400 px-6 mb-6">

                <!-- LEFT -->
                <div class="flex items-center gap-3">

                    <flux:navbar.item href="{{ route('courses.show', $course->id) }}">
                        <flux:icon.arrow-left variant="micro" />
                    </flux:navbar.item>

                    <flux:heading size="xl" class="dark:text-white text-zinc-900">
                        {{ $course->title }}
                    </flux:heading>

                </div>

                <!-- RIGHT -->
                <div class="flex items-center gap-1 mr-5">

                    <!-- COMMENT -->
                    <div x-data="{ open: false }" class="relative">

                        <!-- BUTTON -->
                        <flux:navbar.item
                            @click="open = !open"
                            class="relative cursor-pointer">

                            <flux:icon.chat-bubble-bottom-center-text class="w-5 h-5" />

                            <!-- Notification Dot -->
                            <div class="absolute top-1 right-1 w-2 h-2 rounded-full bg-blue-600"></div>

                        </flux:navbar.item>

                        <!-- Overlay -->
                        <div
                            x-show="open"
                            x-transition.opacity
                            @click="open = false"
                            class="fixed inset-0 z-40">
                        </div>

                        <!-- COMMENT PANEL -->
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                            @click.away="open = false"
                            class="absolute right-0 mt-4 w-[380px] z-50">

                            <!-- Arrow -->
                            <div class="absolute -top-2 right-6 w-4 h-4 rotate-45
                                bg-white dark:bg-zinc-900
                                border-l border-t
                                border-zinc-200 dark:border-zinc-800">
                            </div>

                            <!-- Panel -->
                            <div class="relative overflow-hidden rounded-3xl
                                border border-zinc-200 dark:border-zinc-800
                                bg-white/90 dark:bg-zinc-900/90
                                backdrop-blur-2xl
                                shadow-2xl">

                                <!-- Header -->
                                <div class="flex items-center justify-between
                                    px-6 py-5 border-b border-zinc-200 dark:border-zinc-800">

                                    <div>

                                        <h2 class="font-semibold text-zinc-900 dark:text-white">
                                            Discussion
                                        </h2>

                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                            Share thoughts and ask questions.
                                        </p>

                                    </div>

                                    <flux:button
                                        size="sm"
                                        variant="ghost"
                                        icon="x-mark"
                                        @click="open = false" />

                                </div>

                                <!-- Empty State -->
                                <div class="flex flex-col items-center justify-center
                                    text-center px-8 py-14">

                                    <div class="w-16 h-16 rounded-2xl
                                        bg-blue-600/10
                                        flex items-center justify-center mb-5">

                                        <flux:icon.chat-bubble-left-right
                                            class="w-8 h-8 text-blue-600" />

                                    </div>

                                    <h3 class="font-semibold text-zinc-900 dark:text-white">
                                        No discussions yet
                                    </h3>

                                    <p class="mt-2 text-sm leading-relaxed
                                        text-zinc-500 dark:text-zinc-400 max-w-xs">

                                        Start the first discussion,
                                        ask a question,
                                        or share your thoughts.

                                    </p>

                                </div>

                                <!-- Input -->
                                <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">

                                    <div class="flex items-end gap-3">

                                        <flux:textarea
                                            rows="1"
                                            placeholder="Write a comment..."
                                            class="flex-1 resize-none" />

                                        <flux:button
                                            variant="primary"
                                            color="blue">

                                            Send

                                        </flux:button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- SIDEBAR TOGGLE -->
                    <flux:navbar.item
                        @click="sidebarOpen = !sidebarOpen"
                        class="cursor-pointer">

                        <flux:icon.list-bullet
                            class="transition-all duration-200"
                            x-bind:class="sidebarOpen
        ? 'text-blue-600'
        : 'text-zinc-500 dark:text-zinc-400'" />

                    </flux:navbar.item>

                    <!-- BOOKMARK -->
                    <div x-data="{ bookmarked: false }">

                        <flux:navbar.item
                            @click="bookmarked = !bookmarked"
                            class="cursor-pointer transition-all duration-200">

                            <flux:icon.bookmark
                                class="transition-all duration-200"
                                x-bind:class="bookmarked
        ? 'text-blue-600 fill-blue-600 scale-110'
        : 'text-zinc-500 dark:text-zinc-400'" />

                        </flux:navbar.item>

                    </div>

                </div>

            </div>

            <flux:separator />

            <!-- Main Lesson -->
            <div class="max-w-4xl mx-auto w-full px-6 mt-8">

                <!-- Lesson Header -->
                <div class="flex items-center justify-between mb-8">

                    <div>

                        <flux:text class="text-zinc-500 dark:text-zinc-400">
                            Lesson {{ $currentLessonIndex + 1 }} of {{ $totalLessons }}
                        </flux:text>

                        <flux:heading size="xl" class="mt-2 text-zinc-900 dark:text-white">
                            {{ $lesson->title }}
                        </flux:heading>

                    </div>

                    <!-- Navigation -->
                    <div class="flex items-center gap-4">

                        @if ($previousLesson)

                        <a
                            wire:navigate
                            href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $previousLesson->id]) }}">

                            <flux:button
                                icon="arrow-left"
                                variant="ghost"
                                class="border border-zinc-300 dark:border-zinc-700">
                            </flux:button>

                        </a>

                        @else

                        <flux:button
                            icon="arrow-left"
                            variant="subtle"
                            disabled
                            class="border border-zinc-300 dark:border-zinc-700 opacity-40 cursor-not-allowed">
                        </flux:button>

                        @endif

                        @if ($nextLesson)

                        <a
                            wire:navigate
                            href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $nextLesson->id]) }}">

                            <flux:button
                                icon="arrow-right"
                                variant="ghost"
                                class="border border-zinc-300 dark:border-zinc-700">
                            </flux:button>

                        </a>

                        @else

                        <flux:button
                            icon="arrow-right"
                            variant="subtle"
                            disabled
                            class="border border-zinc-300 dark:border-zinc-700 opacity-40 cursor-not-allowed">
                        </flux:button>

                        @endif

                    </div>

                </div>

                <!-- Video -->
                <div class="w-full rounded-3xl overflow-hidden
                    border border-zinc-200 dark:border-zinc-800
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

                @php

                $completed = auth()->user()
                ->completedLessons
                ->contains($lesson->id);

                @endphp

                @if($completed)

                <flux:button
                    color="emerald"
                    variant="filled"
                    class="px-10 py-6 text-base">

                    Completed

                </flux:button>

                @else

                <form
                    method="POST"
                    action="{{ route('lessons.complete', [
        'course' => $course->id,
        'lesson' => $lesson->id
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

        <!-- Sidebar -->
        <flux:sidebar
            sticky
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            class="w-80 h-screen border-l border-zinc-200 dark:border-zinc-800
            bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white
            p-5 overflow-y-auto">

            <flux:heading size="lg" class="mb-6 text-zinc-900 dark:text-white">
                Course Content
            </flux:heading>

            <div class="border border-zinc-200 dark:border-zinc-800 rounded-2xl
                overflow-hidden divide-y divide-zinc-200 dark:divide-zinc-800">

                @foreach ($course->modules as $module)

                <div x-data="{ open: true }" class="bg-white dark:bg-zinc-900">

                    <!-- Module Header -->
                    <button
                        @click="open = !open"
                        class="w-full flex items-center justify-between p-4
                        hover:bg-zinc-100 dark:hover:bg-zinc-800
                        transition-colors text-left">

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

                    <!-- Lessons -->
                    <div
                        x-show="open"
                        x-transition
                        class="divide-y divide-zinc-200 dark:divide-zinc-800
                        bg-white dark:bg-zinc-900">

                        @foreach ($module->lessons as $lesson)

                        <a
                            wire:navigate
                            href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $lesson->id]) }}"
                            class="p-4 flex items-center gap-3
                            hover:bg-zinc-100 dark:hover:bg-zinc-800
                            transition-colors
                            {{ request()->route('lesson') == $lesson->id ? 'bg-zinc-100 dark:bg-zinc-800' : '' }}">

                            @php
                            $isCompleted = auth()->user()
                            ->completedLessons
                            ->contains($lesson->id);
                            @endphp

                            <input
                                type="checkbox"
                                disabled
                                class="accent-blue-700 dark:accent-blue-600"
                                {{ $isCompleted ? 'checked' : '' }}>

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