<flux:card
    class="w-full lg:w-96 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-5 md:p-7 h-fit">
    <div class="flex items-center gap-4">
        <flux:card variant="subtle"
            class="flex w-[68px] shrink-0 flex-col items-center justify-center bg-zinc-100 !p-4 dark:bg-zinc-800">
            <span class="text-3xl font-bold leading-none text-zinc-900 dark:text-white">
                {{ $event->start_time->format('d') }}
            </span>
            <span class="mt-1 text-xs font-semibold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">{{ $event->start_time->format('M') }}</span>
        </flux:card>
        <div class="min-w-0">
            <flux:heading level="3" class="break-words text-sm font-semibold text-zinc-900 dark:text-white">
                {{ $event->start_time->translatedFormat('l, F d') }}
            </flux:heading>
            <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                {{ $event->start_time->translatedFormat('h:i A') }}
                - {{ $event->end_time->translatedFormat('h:i A') }}
                WIB
            </flux:text>
        </div>
    </div>

    <flux:separator class="my-6" />

    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <div class="rounded-2xl bg-zinc-100 p-3 dark:bg-zinc-800">
                <flux:icon.video-camera class="size-5 text-zinc-500 dark:text-zinc-400" />
            </div>
            <flux:heading class="text-base font-medium text-zinc-900 dark:text-white">
                {{ $event->delivery_type }}
            </flux:heading>
        </div>

        @if($event->repeat_info)
            <div class="flex items-start gap-4">
                <div class="rounded-2xl bg-zinc-100 p-3 dark:bg-zinc-800">
                    <flux:icon.calendar-date-range class="size-5 text-zinc-500 dark:text-zinc-400" />
                </div>
                <div class="min-w-0">
                    <flux:heading class="text-base font-medium text-zinc-900 dark:text-white">
                        {{ $event->repeat_info['title'] }}
                    </flux:heading>
                    <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $event->repeat_info['subtitle'] }}
                    </flux:text>
                    <flux:link href="{{ route('events.index') }}" class="mt-2 inline-block text-sm text-blue-600 dark:text-blue-500">
                        Show all events
                    </flux:link>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <div class="rounded-2xl bg-zinc-100 p-3 dark:bg-zinc-800">
                <flux:icon.calendar-days class="size-5 text-zinc-500 dark:text-zinc-400" />
            </div>
            <flux:heading class="text-base font-medium text-zinc-900 dark:text-white">
                @if (now()->lt($event->start_time))
                    Starts {{ $event->start_time->diffForHumans() }}
                @elseif (now()->between($event->start_time, $event->end_time))
                    Event is Live Now
                @else
                    Ended {{ $event->end_time->diffForHumans() }}
                @endif
            </flux:heading>
        </div>
    </div>
</flux:card>
