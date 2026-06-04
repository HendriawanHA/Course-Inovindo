<x-app-layout>
    <flux:main class="flex-1 p-4 md:p-6 lg:p-8 bg-zinc-100 dark:bg-zinc-900">
        <x-courses.page-header
            icon="calendar-days"
            title="Events" />

        <flux:separator class="mb-8" />

        <div class="max-w-3xl mx-auto w-full">
            <x-courses.events.event-filter
                :filter="$filter" />

            <flux:heading size="xl" class="hidden md:block mb-4 text-zinc-900 dark:text-white !font-bold">
                New Event
            </flux:heading>

            <x-courses.events.featured-card
                :featuredEvent="$featuredEvent" />

            <x-courses.events.monthly-section
                :events="$events" />

            <x-courses.events.event-list
                :events="$events" />
        </div>
    </flux:main>
</x-app-layout>