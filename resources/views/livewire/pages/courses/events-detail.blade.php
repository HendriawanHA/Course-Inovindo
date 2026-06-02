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
                <flux:heading size="xl" class="text-zinc-900 dark:text-white !font-bold">
                    {{ $event->title }}
                </flux:heading>

                <flux:heading size="lg" class="mt-10 mb-3 text-zinc-900 dark:text-white !font-bold">
                    Details
                </flux:heading>

                <flux:heading size="xl" class="text-zinc-900 dark:text-white !font-bold">
                    {{ $event->event_type }}
                </flux:heading>

                <div    
                    class="prose dark:prose-invert max-w-none text-justify prose-p:my-1 prose-li:my-0 prose-headings:mb-2 prose-headings:mt-4">
                    {!! $event->description !!}
                </div>
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
