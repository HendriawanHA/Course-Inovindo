@if($mode === 'saved')
<div class="absolute bottom-3 left-3">

    @if($course->is_completed)

    <div class="px-3 py-1 rounded-full
    bg-emerald-500/90
    text-white text-xs font-semibold
    backdrop-blur-xl">

        Completed

    </div>

    @elseif($course->progress > 0)

    <div class="px-3 py-1 rounded-full
        bg-blue-600/90
        text-white text-xs font-semibold
        backdrop-blur-xl">

        In Progress

    </div>

    @else

    <div class="px-3 py-1 rounded-full
        bg-zinc-900/80
        text-white text-xs font-semibold
        backdrop-blur-xl">

        Saved

    </div>

    @endif

</div>
@endif