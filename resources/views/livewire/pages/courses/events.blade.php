<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-50 dark:bg-zinc-950 min-h-screen">

        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <flux:heading size="xl" class="text-zinc-900 dark:text-white">Events</flux:heading>
        </div>

        <flux:separator class="mb-8" />

        <!-- Konten Utama yang di Tengah -->
        <div class="max-w-3xl mx-auto w-full">

            <!-- Filter Tabs -->
            <div class="flex items-center gap-2 mb-8">

                {{-- All --}}
                <a href="{{ route('events.index', ['filter' => 'all']) }}">
                    <flux:button
                        variant="{{ $filter === 'all' ? 'filled' : 'subtle' }}">

                        All Events

                    </flux:button>
                </a>

                {{-- Upcoming --}}
                <a href="{{ route('events.index', ['filter' => 'upcoming']) }}">
                    <flux:button
                        variant="{{ $filter === 'upcoming' ? 'filled' : 'subtle' }}">

                        Upcoming

                    </flux:button>
                </a>

                {{-- Past --}}
                <a href="{{ route('events.index', ['filter' => 'past']) }}">
                    <flux:button
                        variant="{{ $filter === 'past' ? 'filled' : 'subtle' }}">

                        Past Events

                    </flux:button>
                </a>

            </div>

            <!-- Featured Event -->
            <flux:heading size="xl" class="mb-4 text-zinc-900 dark:text-white !font-bold">
                New Event
            </flux:heading>

            @if ($featuredEvent)
            <a href="{{ route('events.show', $featuredEvent->slug) }}">
                <flux:card class="mb-10 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:shadow-xl transition-all">
                    <!-- Event Image -->
                    <div class="relative w-full h-80 bg-zinc-900 rounded-t-2xl overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $featuredEvent->thumbnail) }}""
                            class=" w-full h-full object-cover"
                            alt="Event Thumbnail" />
                    </div>

                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <flux:heading size="xl" class="text-zinc-900 dark:text-white !font-bold leading-tight">
                                {{ $featuredEvent->title }}
                            </flux:heading>
                            <flux:badge rounded color="purple" class="px-5 py-1 whitespace-nowrap font-medium">
                                {{ $featuredEvent->delivery_type }}
                            </flux:badge>
                        </div>

                        <flux:text class="text-zinc-500 dark:text-zinc-400 mt-2">
                            {{ $featuredEvent->start_time->translatedFormat('l, F d, Y • h:i A') }}
                        </flux:text>

                        <div class="flex flex-wrap items-center gap-3 mt-6">
                            <!-- Badge 1: Starts in 6 hours -->
                            @php
                            $now = now();

                            $isUpcoming = $now->lt($featuredEvent->start_time);
                            $isLive = $now->between($featuredEvent->start_time, $featuredEvent->end_time);
                            $isEnded = $now->gt($featuredEvent->end_time);
                            @endphp

                            @if ($isUpcoming)

                            <flux:badge
                                rounded
                                color="green"
                                class="px-5 py-2.5 text-sm font-semibold">

                                Dimulai {{ $featuredEvent->start_time->diffForHumans() }}

                            </flux:badge>

                            @elseif ($isLive)

                            <flux:badge
                                rounded
                                color="red"
                                class="px-5 py-2.5 text-sm font-bold animate-pulse">

                                🔴 LIVE

                            </flux:badge>

                            @elseif ($isEnded)

                            <flux:badge
                                rounded
                                class="px-5 py-2.5 text-sm font-semibold bg-red-600 text-white">

                                Berakhir

                            </flux:badge>

                            @endif

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

            <!-- Monthly Section -->
            <flux:heading size="xl" class="mb-5 text-zinc-900 dark:text-white !font-bold">
                {{ $events->first()?->start_time->translatedFormat('F Y') }}
            </flux:heading>

            @foreach ($events as $event)

            <a href="{{ route('events.show', $event->slug) }}">

                <flux:card class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 hover:shadow-xl transition-all mb-4">

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

    </flux:main>
</x-app-layout>