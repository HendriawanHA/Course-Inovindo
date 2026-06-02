<div class="px-8 mt-10">
        <div class="flex items-center justify-between mb-6">
            <flux:heading size="lg">
                Upcoming Events
            </flux:heading>
            <flux:link href="{{ route('events.index') }}" wire:navigate>
                View all
            </flux:link>
        </div>


        <div class="space-y-4">

            @foreach ($latestEvents as $event)

            <a href="{{ route('events.show', $event->slug) }}" wire:navigate>

                <flux:card class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm hover:shadow-xl transition-all mb-4">

                    <div class="flex flex-col md:flex-row gap-6 items-start">

                        <img
                            src="{{ asset('storage/' . $event->thumbnail) }}"
                            alt="Event"
                            class="w-full md:w-56 h-24 object-cover rounded-2xl" />

                        <div class="flex-1 min-w-0">

                            <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                                {{ $event->title }}
                            </flux:heading>

                            <div class="flex items-center gap-2 mt-3 text-zinc-500 dark:text-zinc-400">

                                <flux:icon.calendar-days variant="micro" />

                                <flux:text class="text-sm">
                                    {{ $event->start_time->format('l, F d, Y • h:i A') }}
                                </flux:text>

                            </div>

                            <div class="flex items-center gap-2 mt-2 text-zinc-500 dark:text-zinc-400">

                                <flux:icon.video-camera variant="micro" />

                                <flux:text class="text-sm">
                                    {{ $event->delivery_type }}
                                </flux:text>

                            </div>

                        </div>

                    </div>

                </flux:card>

            </a>

            @endforeach

        </div>

    </div>