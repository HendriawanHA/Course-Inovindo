<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-100 dark:bg-zinc-900"
        x-data="{
        openPointsModal:false
    }">
        <x-courses.page-header
            icon="trophy"
            title="Leaderboard" />

        <flux:separator class="mb-10" />

        <div class="max-w-5xl mx-auto">
            <x-courses.leaderboard.user-leaderboard
                :user="$user" />

            <div class="flex items-center justify-between mt-10 mb-6">
                <x-courses.leaderboard.leaderboard-filter
                    :filter="$filter" />
                <flux:text
                    @click="openPointsModal = true"
                    class="text-zinc-500 dark:text-zinc-400 text-sm cursor-pointer hover:text-zinc-700 dark:hover:text-zinc-300">

                    How do points work?

                </flux:text>
                <x-courses.leaderboard.point-info />
            </div>

            <x-courses.leaderboard.list
                :leaders="$leaders"
                :filter="$filter" />
        </div>
    </flux:main>
</x-app-layout>