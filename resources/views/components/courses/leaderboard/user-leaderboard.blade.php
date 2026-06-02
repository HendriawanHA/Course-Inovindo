<flux:card class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 shadow-xl">
    <div class="flex items-start justify-between">
        <!-- Left Profile -->
        <div class="flex items-start gap-5">
            <div class="relative">
                <flux:avatar
                    size="xl"
                    circle
                    src="{{ $user->avatar_url }}" />
                <div class="absolute -bottom-1 -right-1">
                    <div class="w-8 h-8 rounded-full bg-amber-500 text-black text-sm font-bold flex items-center justify-center border- border-white dark:border-zinc-900">
                        {{ $user->rank_level }}
                    </div>
                </div>
            </div>
            <div>
                <flux:heading size="xl" class="text-zinc-900 dark:text-white">
                    {{ $user->rank['name']}}
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ $user->points }} points
                </flux:text>
            </div>
        </div>

        <!-- Right Level -->
        <div class="text-right">
            <flux:badge color="amber" class="rounded-full px-5 py-2 gap-2 text-sm font-medium">
                <flux:icon.trophy variant="mini" />
                Level {{ $user->rank_level }}
                <flux:separator vertical />
                {{ $user->rank['name'] }}
            </flux:badge>
            <div class="flex items-center justify-end gap-2 mt-4">
                <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">

                    @if ($user->next_rank)
                    {{ $user->points_to_next_rank }} points to level up
                    @else
                    Max rank reached
                    @endif

                </flux:text>
                <flux:icon.question-mark-circle class="size-4 text-zinc-400" />
            </div>
        </div>
    </div>

    <!-- Rank Progress -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
        @foreach (\App\Models\User::RANKS as $index => $rank)
        @php
        $active = $user->points >= $rank['points'];
        @endphp
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-full border flex items-center justify-center text-lg font-semibold
            {{ $active
                ? 'bg-amber-500 text-black border-amber-500'
                : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-400 dark:text-zinc-500 border-zinc-300 dark:border-zinc-700' }}">
                @if ($active)
                {{ $index + 1 }}
                @else
                <flux:icon.lock-closed variant="mini" />
                @endif
            </div>
            <div>
                <flux:heading
                    size="sm"
                    class="{{ $active ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
                    {{ $rank['name'] }}
                </flux:heading>
                <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
                    {{ $rank['points'] }} points
                </flux:text>
            </div>
        </div>
        @endforeach
    </div>
</flux:card>