<div class="flex justify-center m-8">

    @if (auth()->user()?->completedLessons?->contains($lesson->id))
    <flux:button color="emerald" disabled>
        Completed
    </flux:button>
    @else
    <form method="POST" action="{{ route('lessons.complete', [$course->id, $lesson->id]) }}">
        @csrf
        <flux:button type="submit" icon-trailing="arrow-right">
            Complete Lesson
        </flux:button>
    </form>
    @endif

</div>