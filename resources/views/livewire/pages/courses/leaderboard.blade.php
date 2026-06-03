<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-100 dark:bg-zinc-900">
        <x-courses.page-header
            icon="trophy"
            title="Leaderboard" />

        <flux:separator class="mb-10" />

        <div class="max-w-5xl mx-auto">
            <x-courses.leaderboard.user-leaderboard
                :user="$user" />

            <div class="flex items-center justify-between mt-10 mb-6">
                <x-courses.leaderboard.leaderboard-filter />
                <flux:text class="text-zinc-500 dark:text-zinc-400 text-sm cursor-pointer hover:text-zinc-700 dark:hover:text-zinc-300">
                    How do points work?
                </flux:text>
            </div>

            <x-courses.leaderboard.list
                :leaders="$leaders" />
        </div>
    </flux:main>
</x-app-layout>