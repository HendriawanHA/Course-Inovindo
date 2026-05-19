<x-app-layout>
    <flux:navbar class="flex items-center gap-2 text-zinc-400 px-6">
        <flux:navbar.item href="{{ route('events.index') }}">
            <flux:icon.arrow-uturn-left variant="micro" />
        </flux:navbar.item>
        <flux:heading size="lg" class="dark:text-white">
            {{ $event->title }}
        </flux:heading>
    </flux:navbar>

    <flux:separator />

    <div class="max-w-5xl mx-auto w-full px-6 py-8">

        <!-- Hero Image -->
        <div
            class="w-full h-64 bg-zinc-900 rounded-3xl overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <img src="{{ asset('storage/' . $event->thumbnail) }}" class="w-full h-full object-cover" alt="Event Banner" />
        </div>

        <div class="flex flex-col lg:flex-row gap-8 mt-8">

            <!-- Main Content -->
            <flux:card class="flex-1 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8">
                <flux:heading size="xl" class="text-zinc-900 dark:text-white !font-bold">
                    {{ $event->title }}
                </flux:heading>

                <flux:heading size="lg" class="mt-10 mb-3 text-zinc-900 dark:text-white !font-bold">
                    Details
                </flux:heading>
                <flux:heading size="xl" class="text-zinc-900 dark:text-white !font-bold">
                    {{ $event->event_type }}
                </flux:heading>

                <div
                    class="prose dark:prose-invert max-w-none text-justify
    prose-p:my-1
    prose-li:my-0
    prose-headings:mb-2
    prose-headings:mt-4">

                    {!! $event->description !!}

                </div>
                <flux:separator class="my-8" />

                <flux:heading size="lg" class="mb-4 text-zinc-900 dark:text-white !font-bold">
                    Recording
                </flux:heading>

                <div class="aspect-video bg-black rounded-2xl overflow-hidden">
                    @php
                        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $event->recording_url, $matches);

                        $youtubeId = $matches[1] ?? null;
                    @endphp

                    @if ($youtubeId)
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}"
                            title="Recording" frameborder="0" allowfullscreen>
                        </iframe>
                    @else
                        <div class="flex items-center justify-center h-full text-zinc-500">
                            Recording not available
                        </div>
                    @endif
                </div>

                <flux:text variant="strong" class="mt-4 block text-zinc-900 dark:text-white">
                    Halo teman teman
                </flux:text>
                <flux:text class="mt-1">
                    <flux:link href="#">Show Transcript</flux:link>
                </flux:text>
            </flux:card>

            <!-- Sidebar Info -->
            <flux:card
                class="w-full lg:w-96 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 h-fit">
                <div class="flex items-center gap-4">
                    <flux:card variant="subtle"
                        class="flex flex-col items-center justify-center !p-4 w-[68px] bg-zinc-100 dark:bg-zinc-800">
                        <span class="text-3xl font-bold text-zinc-900 dark:text-white">
                            {{ $event->start_time->format('d') }}
                        </span> <span class="text-xs uppercase font-semibold tracking-widest text-zinc-500 dark:text-zinc-400">{{ $event->start_time->format('M') }}</span>
                    </flux:card>
                    <div>
                        <flux:heading level="3" class="font-semibold text-zinc-900 dark:text-white">
                            {{ $event->start_time->translatedFormat('l, F d') }}
                        </flux:heading>
                        <flux:text class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ $event->start_time->translatedFormat('h:i A') }}
                            - {{ $event->end_time->translatedFormat('h:i A') }}
                            WIB
                        </flux:text>
                    </div>
                </div>

                <flux:separator class="my-6" />

                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-zinc-100 dark:bg-zinc-800 rounded-2xl">
                            <flux:icon.video-camera class="size-5 text-zinc-500 dark:text-zinc-400" />
                        </div>
                        <div>
                            <flux:heading class="text-base font-medium text-zinc-900 dark:text-white">
                                {{ $event->delivery_type }}</flux:heading>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div>
                            @php
                                $title = strtolower($event->title);

                                $repeatText = null;
                                $repeatSubText = null;

                                if (str_contains($title, 'daily')) {
                                    $repeatText = 'Repeats every weekday';
                                    $repeatSubText = '(Monday to Friday)';
                                } elseif (str_contains($title, 'weekly')) {
                                    $repeatText = 'Repeats every week';
                                    $repeatSubText = '(Every week)';
                                } elseif (str_contains($title, 'monthly')) {
                                    $repeatText = 'Repeats every month';
                                    $repeatSubText = '(Once every month)';
                                }
                            @endphp
                            @if ($repeatText)
                                <div class="flex items-start gap-4">
                                    <div class="p-3 bg-zinc-100 dark:bg-zinc-800 rounded-2xl">
                                        <flux:icon.calendar-date-range
                                            class="size-5 text-zinc-500 dark:text-zinc-400" />
                                    </div>
                                    <div>
                                        <flux:heading class="text-base font-medium text-zinc-900 dark:text-white">
                                            {{ $repeatText }}
                                        </flux:heading>
                                        <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $repeatSubText }}
                                        </flux:text>
                                        <flux:link href="#"
                                            class="text-blue-600 dark:text-blue-500 text-sm mt-2 inline-block">
                                            Show all events
                                        </flux:link>
                                    </div>

                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-zinc-100 dark:bg-zinc-800 rounded-2xl">
                            <flux:icon.calendar-days class="size-5 text-zinc-500 dark:text-zinc-400" />
                        </div>
                        <flux:heading class="text-base font-medium text-zinc-900 dark:text-white">
                            @if (now()->lt($event->start_time))
                            Starts {{ $event->start_time->diffForHumans() }}
                            @elseif (now()->between($event->start_time, $event->end_time))
                                🔴 Event is Live Now
                            @else
                            Ended {{ $event->end_time->diffForHumans() }}
                            @endif
                        </flux:heading>
                    </div>
                </div>
            </flux:card>

        </div>
    </div>
</x-app-layout>
