<flux:heading
    size="lg"
    class="mb-4 text-zinc-900 dark:text-white !font-bold">

    {{ $event->video_title }}

</flux:heading>

<div class="aspect-video bg-black rounded-2xl overflow-hidden relative">

    {{-- DRAFT --}}
    @if($event->live_status === 'draft')
    <div class="flex flex-col items-center justify-center
            h-full text-center p-8 bg-zinc-900 text-white">

        <flux:icon.eye-slash
            class="size-12 text-zinc-500 mb-4" />

        <h3 class="text-lg md:text-xl font-semibold">
            Event Not Published
        </h3>

        <p class="mt-2 text-zinc-400 max-w-md">
            This event is still in draft mode
            and not publicly available yet.
        </p>

    </div>

    {{-- UPCOMING --}}
    @elseif($event->live_status === 'upcoming')
    <div class="flex flex-col items-center justify-center
            h-full text-center p-8 bg-zinc-900 text-white">

        <flux:icon.clock
            class="size-12 text-indigo-400 mb-4" />

        <h3 class="text-lg md:text-xl font-semibold">
            Event Has Not Started Yet
        </h3>

        <p class="mt-2 text-zinc-400 max-w-md">
            The live session will be available
            once the event starts.
        </p>

        <div class="mt-6 px-4 py-2 rounded-full
                bg-indigo-500/20
                text-indigo-300 text-sm">

            Upcoming Event

        </div>

    </div>

    {{-- LIVE / ENDED --}}
    @elseif($event->youtube_id)

    {{-- LIVE BADGE --}}
    @if($event->live_status === 'live')
    <div class="absolute top-4 left-4 z-10
                px-4 py-2 rounded-full
                bg-red-600 text-white
                text-xs font-bold
                animate-pulse shadow-lg">

        🔴 LIVE NOW

    </div>

    @endif

    <iframe
        class="w-full h-full"
        src="https://www.youtube.com/embed/{{ $event->youtube_id}}"
        title="{{ $event->video_title }}"
        frameborder="0"
        allowfullscreen>
    </iframe>

    {{-- FALLBACK --}}
    @else

    <div class="flex items-center justify-center
            h-full text-zinc-500 bg-zinc-900">

        Video not available

    </div>

    @endif

</div>