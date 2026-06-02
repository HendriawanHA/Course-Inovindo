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
                    {{ $event->delivery_type }}
                </flux:heading>
            </div>
        </div>

        <div class="flex items-start gap-4">
            <div>
                @if($event->repeat_info)
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-zinc-100 dark:bg-zinc-800 rounded-2xl">
                        <flux:icon.calendar-date-range
                            class="size-5 text-zinc-500 dark:text-zinc-400" />
                    </div>
                    <div>
                        <flux:heading class="text-base font-medium text-zinc-900 dark:text-white">
                            {{ $event->repeat_info['title'] }}
                        </flux:heading>
                        <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $event->repeat_info['subtitle'] }}
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