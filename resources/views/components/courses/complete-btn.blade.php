<div class="flex justify-center px-4 my-8">
    @if (auth()->user()?->completedLessons?->contains($lesson->id))
    <flux:button color="emerald" disabled class="w-full sm:w-auto">
        Completed
    </flux:button>
    @else
    <form method="POST" action="{{ route('lessons.complete', [$course->id, $lesson->id]) }}">
        @csrf
        <flux:button type="submit" icon-trailing="arrow-right" class="w-full sm:w-auto">
            Complete Lesson
        </flux:button>
    </form>
    @endif

</div>