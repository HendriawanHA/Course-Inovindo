<x-app-layout>
    <x-courses.detail-header :title="$event->title" :back-url="route('events.index')" />

    <flux:separator />

    <div class="max-w-5xl mx-auto w-full px-4 md:px-6 py-6 md:py-8">
        <x-courses.events.banner :event="$event" />

        <div class="flex flex-col lg:flex-row gap-8 mt-8">
            <flux:card class="flex-1 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 md:p-8">

                <x-courses.events.events-desc :event="$event" />

                <flux:separator class="my-8" />

                <x-courses.events.video :event="$event" />

            </flux:card>

            <x-courses.events.sidebar-info :event="$event" />
        </div>
    </div>
</x-app-layout>
