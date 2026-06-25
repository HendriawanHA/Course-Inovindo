@foreach ($events as $event)

@if($event->is_paid)

<div
    class="cursor-pointer"
    @click="
    $dispatch('open-event-modal', {

        title: '{{ $event->title }}',

        thumbnail: '{{ $event->thumbnail_url }}',

        instructor: '{{ $event->instructor?->name }}',

        avatar: @js($event->instructor?->avatar_url),

        date: '{{ $event->start_time->format('d M Y') }}',

        time: '{{ $event->start_time->format('H:i') }}',

        description: @js($event->description),

        delivery: '{{ ucfirst($event->delivery_type) }}',

        capacity: '{{ $event->capacity }}',

        location: '{{ $event->location ?? $event->city ?? 'Online Meeting' }}',

        price: '{{ number_format($event->price,0,',','.') }}',

        is_paid: true,

        slug: '{{ $event->slug }}'
    })
">

    @else

    <a
        href="{{ route('events.show', $event->slug) }}"
        class="block">

        @endif

        <flux:card
            class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 md:p-6 hover:shadow-xl hover:-translate-y-1 transition-all mb-4">

            <div class="flex flex-col md:flex-row gap-6 items-start">

                <img
                    src="{{ $event->thumbnail_url }}"
                    alt="Event"
                    class="w-full md:w-56 h-28 md:h-24 object-cover rounded-2xl" />

                <div class="flex-1 min-w-0">

                    <div class="flex justify-between items-start gap-3">

                        <flux:heading
                            size="lg"
                            class="line-clamp-2 text-zinc-900 dark:text-white">

                            {{ $event->title }}

                        </flux:heading>

                        @if($event->is_paid)

                        <flux:badge
                            color="amber"
                            size="sm">
                            Paid
                        </flux:badge>

                        @else

                        <flux:badge
                            color="emerald"
                            size="sm">
                            Free
                        </flux:badge>

                        @endif

                    </div>

                    <div class="flex items-center gap-2 mt-3 text-zinc-500 dark:text-zinc-400">

                        <flux:icon.calendar-days variant="micro" />

                        <flux:text class="text-sm">

                            {{ $event->start_time->format('l, F d, Y • h:i A') }}

                        </flux:text>

                    </div>

                    <div class="flex items-center gap-2 mt-2">

                        <flux:icon.video-camera
                            variant="micro" />

                        <flux:badge
                            color="purple"
                            size="sm">

                            {{ ucfirst($event->delivery_type) }}

                        </flux:badge>

                    </div>

                </div>

            </div>

        </flux:card>

        @if($event->is_paid)
</div>
@else
</a>
@endif

@endforeach