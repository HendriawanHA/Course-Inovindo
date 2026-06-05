<div
    sticky
    x-show="sidebarOpen"
    @click.away="window.innerWidth < 1024 ? sidebarOpen = false : null"

    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-full"
    x-transition:enter-end="opacity-100 translate-x-0"

    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-full"

    class="
        fixed lg:sticky
        top-0 right-0
        z-50 lg:z-auto

        w-[90vw] sm:w-[380px] lg:w-80
        h-screen

        border-l border-zinc-200 dark:border-zinc-800
        bg-white dark:bg-zinc-900

        text-zinc-900 dark:text-white
        p-4 lg:p-5

        overflow-y-auto
        shadow-2xl lg:shadow-none
    ">

    <!-- Mobile Header -->
    <div class="flex items-center justify-between mb-6 lg:hidden">

        <flux:heading size="lg">
            Course Content
        </flux:heading>

        <button
            @click="sidebarOpen = false"
            class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">

            <flux:icon.x-mark />

        </button>

    </div>

    <!-- Desktop Header -->
    <flux:heading
        size="lg"
        class="hidden lg:block mb-6 text-zinc-900 dark:text-white">

        Course Content

    </flux:heading>

    <div class="border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden divide-y divide-zinc-200 dark:divide-zinc-800">

        @foreach ($course->modules as $module)

        <div x-data="{ open: true }">

            <button
                type="button"
                @click="open = !open"
                class="w-full flex items-center justify-between p-4 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-left">

                <div class="flex items-center gap-3 min-w-0">

                    <flux:icon.chevron-right
                        variant="micro"
                        class="transition-transform duration-300 text-zinc-400 shrink-0"
                        x-bind:class="open ? 'rotate-90' : ''" />

                    <div class="min-w-0">

                        <p class="font-semibold truncate">
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
                class="divide-y divide-zinc-200 dark:divide-zinc-800">

                @foreach ($module->lessons as $moduleLesson)

                @php
                $isCompleted = auth()->user()?->completedLessons?->contains($moduleLesson->id);
                $isActive = (int) request()->route('lesson') === (int) $moduleLesson->id;
                @endphp

                <a
                    wire:navigate
                    href="{{ route('courses.video', [
                        'course' => $course->id,
                        'lesson' => $moduleLesson->id
                    ]) }}"

                    @click="window.innerWidth < 1024 ? sidebarOpen = false : null"

                    class="
                        p-4 flex items-start gap-3
                        hover:bg-zinc-100 dark:hover:bg-zinc-800
                        transition-colors

                        {{ $isActive
                            ? 'bg-zinc-100 dark:bg-zinc-800'
                            : ''
                        }}
                    ">

                    <input
                        type="checkbox"
                        disabled
                        class="mt-1 accent-blue-700 dark:accent-blue-600 shrink-0"
                        {{ $isCompleted ? 'checked' : '' }}>

                    <span
                        class="text-sm leading-relaxed text-zinc-700 dark:text-zinc-200">

                        {{ $moduleLesson->title }}

                    </span>

                </a>

                @endforeach

            </div>

        </div>

        @endforeach

    </div>

</div>

<!-- MOBILE BACKDROP -->
<div
    x-show="sidebarOpen && window.innerWidth < 1024"
    x-transition.opacity
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-black/40 z-40 lg:hidden">
</div>