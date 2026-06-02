<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-100 dark:bg-zinc-900">

        <!-- Page Header -->
        <x-courses.page-header
            icon="calendar-days"
            title="Events" />

        <flux:separator class="mb-8" />

        <!-- Konten Utama yang di Tengah -->
        <div class="max-w-3xl mx-auto w-full">
            <!-- Filter Tabs -->
            <x-courses.events.event-filter
                :filter="$filter" />

            <!-- Featured Event -->
            <flux:heading size="xl" class="mb-4 text-zinc-900 dark:text-white !font-bold">
                New Event
            </flux:heading>

            <x-courses.events.featured-card
                :featuredEvent="$featuredEvent" />

            <!-- Monthly Section -->
            <x-courses.events.monthly-section
                :events="$events" />

            <x-courses.events.event-list
                :events="$events" />

        </div>

    </flux:main>
</x-app-layout>