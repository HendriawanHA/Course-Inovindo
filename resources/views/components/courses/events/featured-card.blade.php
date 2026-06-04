@if ($featuredEvent)
<a href="{{ route('events.show', $featuredEvent->slug) }}">
    <flux:card class="mb-10 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:shadow-xl transition-all">
        <!-- Event Image -->
        <div class="relative w-full h-52 md:h-64 lg:h-80 bg-zinc-900 rounded-t-2xl overflow-hidden">
            <img
                src="{{ $featuredEvent->thumbnail_url }}""
                            class=" w-full h-full object-cover"
                alt="Event Thumbnail" />
        </div>

        <div class="py-6 md:p-6">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                <flux:heading size="xl" class="text-zinc-900 dark:text-white !font-bold leading-tight">
                    {{ $featuredEvent->title }}
                </flux:heading>
                <flux:badge rounded color="purple" class="w-fit px-4 py-1 my-2 whitespace-nowrap font-medium">
                    {{ $featuredEvent->delivery_type }}
                </flux:badge>
            </div>

            <flux:text class="text-zinc-500 dark:text-zinc-400 mt-2">
                {{ $featuredEvent->start_time->translatedFormat('l, F d, Y • h:i A') }}
            </flux:text>

            <div class="flex flex-wrap items-center gap-3 mt-6">
                <!-- Badge 1: Starts in 6 hours -->
                <flux:badge
                    rounded
                    color="{{ $featuredEvent->status_badge['color'] }}"
                    class="px-5 py-2.5 text-sm font-medium border border-zinc-300 dark:border-zinc-700">
                    {{ $featuredEvent->status_badge['text'] }}
                </flux:badge>

                <!-- Badge 2: Live Stream -->
                <flux:badge
                    rounded
                    color="zinc"
                    class="px-5 py-2.5 text-sm font-medium border border-zinc-300 dark:border-zinc-700">
                    <div class="flex items-center gap-2">
                        <flux:icon.video-camera variant="micro" />
                        <span>{{ $featuredEvent->delivery_type }}</span>
                    </div>
                </flux:badge>
            </div>
        </div>
    </flux:card>
</a>
@endif