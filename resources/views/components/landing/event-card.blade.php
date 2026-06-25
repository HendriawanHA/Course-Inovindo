@props(['event'])

<flux:card>

    <img
        src="{{ asset('storage/'.$event->thumbnail) }}"
        class="w-full h-48 object-cover rounded-xl">

    <div class="mt-4">

        <h3 class="font-semibold">
            {{ $event->title }}
        </h3>

        <p class="text-sm text-zinc-500 mt-2">
            {{ $event->start_date }}
        </p>

        <flux:button
            size="sm"
            class="mt-4 w-full">

            Join Event

        </flux:button>

    </div>

</flux:card>