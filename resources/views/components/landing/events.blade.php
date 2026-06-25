@props(['events'])

<section id="events" class="py-20">

    <div class="max-w-7xl mx-auto px-6">

        <flux:heading size="xl">
            Upcoming Events
        </flux:heading>

        <div class="grid md:grid-cols-3 gap-6 mt-8">

            @foreach($events as $event)

                <x-landing.event-card
                    :event="$event" />

            @endforeach

        </div>

    </div>

</section>