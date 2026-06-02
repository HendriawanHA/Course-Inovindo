<flux:sidebar sticky
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-full"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-full"
    class="w-80 h-screen border-l border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white p-5 overflow-y-auto">

    <!-- Sidebar Heading -->
    <flux:heading size="lg" class="mb-6 text-zinc-900 dark:text-white">
        Course Content
    </flux:heading>

    <!-- Modules Container -->
    <div class="border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden divide-y divide-zinc-200 dark:divide-zinc-800">
        @foreach ($course->modules as $module)
        <div x-data="{ open: true }" class="bg-white dark:bg-zinc-900">

            <!-- Module Header Button -->
            <button type="button"
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

            <!-- Lessons List -->
            <div x-show="open"
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

                    <input type="checkbox"
                        disabled
                        class="accent-blue-700 dark:accent-blue-600"
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