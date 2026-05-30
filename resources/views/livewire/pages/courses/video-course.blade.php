<x-app-layout>

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex flex-1">

        <!-- Main Content -->
        <div class="flex-1 flex flex-col pt-5 bg-zinc-50 dark:bg-zinc-900 min-h-screen">

            <!-- Header -->
            <div class="flex justify-between items-center gap-2 text-zinc-500 dark:text-zinc-400 px-6 mb-6">

                <!-- LEFT -->
                <div class="flex items-center gap-3">

                    <flux:navbar.item href="{{ request('back', route('courses.show', $course->id)) }}">

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
                        <flux:navbar.item
                            @click="document.getElementById('discussion-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' })"
                            class="relative cursor-pointer">
                            <flux:icon.chat-bubble-bottom-center-text class="w-5 h-5" />

                            @if ($discussions->count())
                                <div class="absolute top-1 right-1 w-2 h-2 rounded-full bg-indigo-500"></div>
                            @endif
                        </flux:navbar.item>
                    </div>

                    <!-- SIDEBAR TOGGLE -->
                    <flux:navbar.item @click="sidebarOpen = !sidebarOpen" class="cursor-pointer">

                        <flux:icon.list-bullet class="transition-all duration-200"
                            x-bind:class="sidebarOpen
                                ?
                                'text-indigo-500' :
                                'text-zinc-500 dark:text-zinc-400'" />

                    </flux:navbar.item>

                    <!-- BOOKMARK -->
                    <div x-data="{ bookmarked: false }">

                        <flux:navbar.item @click="bookmarked = !bookmarked"
                            class="cursor-pointer transition-all duration-200">

                            <flux:icon.bookmark class="transition-all duration-200"
                                x-bind:class="bookmarked
                                    ?
                                    'text-blue-500 fill-blue-500 scale-110' :
                                    'text-zinc-500 dark:text-zinc-400'" />

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
                            <a wire:navigate
                                href="{{ route('courses.video', [
                                    'course' => $course->id,
                                    'lesson' => $previousLesson->id,
                                ]) }}">

                                <flux:button icon="arrow-left" variant="ghost"
                                    class="border border-zinc-300 dark:border-zinc-700">
                                </flux:button>

                            </a>
                        @else
                            <flux:button icon="arrow-left" variant="subtle" disabled
                                class="border border-zinc-300 dark:border-zinc-700 opacity-40 cursor-not-allowed">
                            </flux:button>
                        @endif

                        @if ($nextLesson)
                            <a wire:navigate
                                href="{{ route('courses.video', [
                                    'course' => $course->id,
                                    'lesson' => $nextLesson->id,
                                ]) }}">

                                <flux:button icon="arrow-right" variant="ghost"
                                    class="border border-zinc-300 dark:border-zinc-700">
                                </flux:button>

                            </a>
                        @else
                            <flux:button icon="arrow-right" variant="subtle" disabled
                                class="border border-zinc-300 dark:border-zinc-700 opacity-40 cursor-not-allowed">
                            </flux:button>
                        @endif

                    </div>

                </div>

                <!-- Video -->
                <div
                    class="w-full rounded-3xl overflow-hidden
                    border border-zinc-200 dark:border-zinc-800
                    bg-white dark:bg-zinc-900 shadow-xl">

                    <iframe width="100%" height="450" src="{{ $lesson->youtube_embed_url }}" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>

                </div>

            </div>

            <flux:separator class="my-10" />

            <livewire:discussions.lesson-discussion :lesson="$lesson" />

            <!-- Complete Button -->
            <div class="flex justify-center mb-8">

                @php
                    $completed = auth()->user()?->completedLessons?->contains($lesson->id);
                @endphp

                @if ($completed)
                    <flux:button color="emerald" variant="filled" class="px-10 py-6 text-base" disabled>

                        Completed

                    </flux:button>
                @else
                    <form method="POST"
                        action="{{ route('lessons.complete', [
                            'course' => $course->id,
                            'lesson' => $lesson->id,
                        ]) }}">

                        @csrf

                        <flux:button type="submit" variant="filled" icon-trailing="arrow-right"
                            class="px-10 py-6 text-base">

                            Complete Lesson

                        </flux:button>

                    </form>
                @endif

            </div>

        </div>

        <!-- Sidebar -->
        <flux:sidebar sticky x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            class="w-80 h-screen border-l border-zinc-200 dark:border-zinc-800
            bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white
            p-5 overflow-y-auto">

            <flux:heading size="lg" class="mb-6 text-zinc-900 dark:text-white">
                Course Content
            </flux:heading>

            <div
                class="border border-zinc-200 dark:border-zinc-800 rounded-2xl
                overflow-hidden divide-y divide-zinc-200 dark:divide-zinc-800">

                @foreach ($course->modules as $module)
                    <div x-data="{ open: true }" class="bg-white dark:bg-zinc-900">

                        <!-- Module Header -->
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between p-4
                        hover:bg-zinc-100 dark:hover:bg-zinc-800
                        transition-colors text-left">

                            <div class="flex items-center gap-3">

                                <flux:icon.chevron-right variant="micro"
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
                        <div x-show="open" x-transition
                            class="divide-y divide-zinc-200 dark:divide-zinc-800
                        bg-white dark:bg-zinc-900">

                            @foreach ($module->lessons as $moduleLesson)
                                @php
                                    $isCompleted = auth()->user()?->completedLessons?->contains($moduleLesson->id);

                                    $isActive = (int) request()->route('lesson') === (int) $moduleLesson->id;
                                @endphp

                                <a wire:navigate
                                    href="{{ route('courses.video', [
                                        'course' => $course->id,
                                        'lesson' => $moduleLesson->id,
                                    ]) }}"
                                    class="p-4 flex items-center gap-3
                            hover:bg-zinc-100 dark:hover:bg-zinc-800
                            transition-colors
                            {{ $isActive ? 'bg-zinc-100 dark:bg-zinc-800' : '' }}">

                                    <input type="checkbox" disabled class="accent-blue-700 dark:accent-blue-600"
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
