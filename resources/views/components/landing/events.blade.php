@props(['events'])

<section
    id="events"
    class="
    relative
    overflow-hidden

    py-24

    bg-zinc-50
    dark:bg-zinc-900
">

    <x-landing.dark-bg />

    <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 lg:px-24">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div>

                <div class="flex items-center gap-3 mb-3">

                    <div
                        class="
                        h-[3px]
                        w-12
                        rounded-full

                        bg-gradient-to-r
                        from-blue-700
                        to-emerald-500
                    ">
                    </div>

                    <span
                        class="
                        text-sm
                        font-medium

                        text-blue-700
                        dark:text-emerald-400
                    ">

                        Event & Webinar

                    </span>

                </div>

                <h2
                    class="
                    text-3xl
                    md:text-5xl

                    font-bold

                    text-zinc-900
                    dark:text-white
                ">

                    Upcoming

                    <span
                        class="
                        bg-gradient-to-r
                        from-blue-700
                        to-emerald-500
                        bg-clip-text
                        text-transparent
                    ">

                        Events

                    </span>

                </h2>

            </div>

            <a href="{{ route('events.index') }}">

                <flux:button
                    class="
                    !bg-emerald-500
                    hover:!bg-emerald-600
                    !text-white
                    ">
                    Lihat Semua Event
                </flux:button>

            </a>

        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">

            @foreach($events as $event)

            <x-landing.event-card :event="$event" />

            @endforeach

        </div>

    </div>

</section>