<div class="flex items-center justify-between mb-8">

    <div>
        <flux:text class="text-zinc-500 dark:text-zinc-400">
            Lesson {{ $currentIndex + 1 }} of {{ $totalLessons }}
        </flux:text>

        <flux:heading size="xl" class="mt-2 text-zinc-900 dark:text-white">
            {{ $lesson->title }}
        </flux:heading>
    </div>

    <!-- NAVIGATION -->
    <div class="flex items-center gap-4">

        @if ($previousLesson)
        <a wire:navigate href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $previousLesson->id]) }}">
            <flux:button icon="arrow-left" variant="filled" />
        </a>
        @else
        <flux:button icon="arrow-left" variant="subtle" disabled />
        @endif

        @if ($nextLesson)
        <a wire:navigate href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $nextLesson->id]) }}">
            <flux:button icon="arrow-right" variant="filled" />
        </a>
        @else
        <flux:button icon="arrow-right" variant="subtle" disabled />
        @endif

    </div>

</div>