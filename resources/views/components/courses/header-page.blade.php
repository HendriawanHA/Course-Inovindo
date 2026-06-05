@props(['course', 'targetLesson', 'hasStarted', 'isCompleted',])

<div class="flex flex-col text-center md:flex-row md:items-center justify-between gap-4">
    <flux:heading size="xl" class="text-2xl md:text-4xl">
        Welcome, {{ auth()->user()->name }}.
    </flux:heading>

    @if ($targetLesson)

    <flux:button
        href="{{ route('courses.video', [
                'course' => $course->id,
                'lesson' => $targetLesson->id,
                'back' => route('courses.show', [
    'id' => $course->id,
    'back' => request('back')
])
            ]) }}"
        wire:navigate
        variant="primary"
        class="w-full md:w-auto !rounded-full hover:!text-white
            !border-2 border-blue-700/60 hover:bg-blue-700">

        @if($isCompleted)
        Review
        @elseif($hasStarted)
        Continue
        @else
        Start
        @endif

    </flux:button>

    @endif
</div>