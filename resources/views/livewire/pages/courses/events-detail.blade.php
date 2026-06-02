<x-app-layout>
    <x-courses.detail-header
        :title="$event->title"
        :back-url="route('events.index')" />

    <flux:separator />

    <div class="max-w-5xl mx-auto w-full px-6 py-8">

        <!-- Hero Image -->
        <x-courses.events.banner
            :event="$event" />

        <div class="flex flex-col lg:flex-row gap-8 mt-8">

            <!-- Main Content -->
            <flux:card class="flex-1 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8">

                <x-courses.events.events-desc :event="$event" />

                <flux:separator class="my-8" />

                <x-courses.events.video
                    :event="$event" />

                <flux:text variant="strong" class="mt-4 block text-zinc-900 dark:text-white">
                    Halo teman teman
                </flux:text>
                <flux:text class="mt-1">
                    <flux:link href="#">Show Transcript</flux:link>
                </flux:text>
            </flux:card>

            <!-- Sidebar Info -->
            <x-courses.events.sidebar-info
                :event="$event" />

        </div>
    </div>
</x-app-layout>
