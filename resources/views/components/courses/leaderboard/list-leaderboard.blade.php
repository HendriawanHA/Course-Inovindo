<flux:card class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden divide-y divide-zinc-200 dark:divide-zinc-800 shadow-xl">

    @forelse ($leaders as $leader)

    <div class="flex items-center justify-between p-5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">

        <div class="flex items-center gap-5">

            <!-- Rank -->
            <div class="w-10 text-center">

                @if ($leader->rank <= 3)
                    <div class="w-9 h-9 rounded-full bg-amber-500 text-black font-bold flex items-center justify-center text-lg">
                    {{ $leader->rank }}
            </div>
            @else
            <div class="text-xl font-bold text-zinc-400 dark:text-zinc-500">
                {{ $leader->rank }}
            </div>
            @endif

        </div>

        <!-- Avatar -->
        <flux:avatar size="md" circle src="{{ $leader->avatar_url }}" />

        <!-- User Info -->
        <div>
            <flux:heading size="sm" class="text-zinc-900 dark:text-white">
                {{ $leader->name }}
            </flux:heading>

            <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ $leader->bio ?? 'No bio yet' }}
            </flux:text>
        </div>

    </div>

    <!-- SCORE -->
    <div class="text-right">

        <div class="text-emerald-600 dark:text-emerald-400 font-bold text-xl">
            {{ $leader->completed_count }}
        </div>

        <flux:text class="text-xs text-zinc-400">
            courses completed
        </flux:text>

    </div>

    </div>

    @empty

    <div class="p-6 text-center text-zinc-500">
        No leaderboard data found
    </div>

    @endforelse

</flux:card>