@foreach ($events as $event)

@php
$eventModalData = [
    'title' => addslashes($event->title),
    'thumbnail' => $event->thumbnail_url,
    'instructor' => $event->instructor?->name ?? 'Unknown',
    'avatar' => $event->instructor?->avatar_url ?? '',
    'date' => $event->start_time->format('d M Y'),
    'time' => $event->start_time->format('H:i'),
    'description' => $event->description,
    'delivery' => ucfirst($event->delivery_type),
    'capacity' => $event->capacity,
    'location' => $event->location ?? $event->city ?? 'Online Meeting',
    'price' => number_format((float) ($event->price ?? 0), 0, ',', '.'),
    'is_paid' => true,
    'slug' => $event->slug,
    'buyUrl' => route('events.buy', $event->slug),
];
$canAccess = $event->canAccess(auth()->id());
$isPurchased = $event->isPurchasedBy(auth()->id());
@endphp

@if($event->is_paid && ! $canAccess)
<div
    class="cursor-pointer"
    @click.stop="$dispatch('open-event-modal', @js($eventModalData))"
>
    @else
    <a
        href="{{ route('events.show', $event->slug) }}"
        class="block">
        @endif

        <flux:card
            class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 md:p-6 hover:shadow-xl hover:-translate-y-1 transition-all mb-4">

            <div class="flex flex-col md:flex-row gap-6 items-start">

                <div class="relative w-full md:w-56 h-28 md:h-24 shrink-0">
                    <img
                        src="{{ $event->thumbnail_url }}"
                        alt="Event"
                        class="w-full h-full object-cover rounded-2xl" />

                    <div class="absolute bottom-2 right-2 flex gap-1">
                        @if($isPurchased)
                        <flux:badge
                            class="!bg-emerald-500 !text-white font-semibold border-none shadow-sm"
                            size="sm">
                            Sudah Dibeli
                        </flux:badge>
                        @elseif($event->is_paid)
                        <flux:badge
                            class="!bg-amber-500 !text-white font-semibold border-none shadow-sm"
                            size="sm">
                            Paid
                        </flux:badge>
                        @else
                        <flux:badge
                            class="!bg-emerald-600 !text-white font-semibold border-none shadow-sm"
                            size="sm">
                            Free
                        </flux:badge>
                        @endif
                    </div>
                </div>

                <div class="flex-1 min-w-0">

                    <div class="flex justify-between items-start gap-3">

                        <flux:heading
                            size="lg"
                            class="line-clamp-2 text-zinc-900 dark:text-white">
                            {{ $event->title }}
                        </flux:heading>

                        @if(! $event->is_paid && $event->price > 0)
                            <div class="shrink-0 text-right">
                                <span class="text-sm text-zinc-400 line-through">Rp{{ number_format((float) $event->price, 0, ',', '.') }}</span>
                            </div>
                        @elseif($event->is_paid)
                            <div class="shrink-0 text-right">
                                <span class="text-lg font-bold text-blue-700">Rp{{ number_format((float) $event->price, 0, ',', '.') }}</span>
                            </div>
                        @endif

                    </div>

                    <div class="flex items-center gap-2 mt-3 text-zinc-500 dark:text-zinc-400">
                        <flux:icon.calendar-days variant="micro" />
                        <flux:text class="text-sm">
                            {{ $event->start_time->format('l, F d, Y • h:i A') }}
                        </flux:text>
                    </div>

                    <div class="flex items-center gap-2 mt-2">
                        <flux:icon.video-camera variant="micro" />
                        <flux:badge
                            color="purple"
                            size="sm">
                            {{ ucfirst($event->delivery_type) }}
                        </flux:badge>
                    </div>

                </div>

            </div>

        </flux:card>

        @if($event->is_paid && ! $canAccess)
</div>
@else
</a>
@endif

@endforeach