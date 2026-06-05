<flux:card class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden divide-y divide-zinc-200 dark:divide-zinc-800 shadow-xl">
    @foreach ($leaders as $index => $leader)

    <div class="flex items-center justify-between gap-3 p-4 md:p-5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">

        <!-- LEFT SIDE -->
        <div class="flex items-center gap-3 flex-1 min-w-0">

            <!-- Rank -->
            <div class="w-8 shrink-0 text-center">

                @if ($index < 3)

                    <div class="w-8 h-8 rounded-full bg-amber-500 text-black font-bold flex items-center justify-center text-sm">
                    {{ $index + 1 }}
            </div>

            @else

            <div class="text-base font-bold text-zinc-400 dark:text-zinc-500">
                {{ $index + 1 }}
            </div>

            @endif

        </div>

        <!-- Avatar -->
        <flux:avatar
            size="sm"
            circle
            class="shrink-0"
            src="{{ $leader->avatar_url }}" />

        <!-- User Info -->
        <div class="flex-1 min-w-0">

            <flux:heading
                size="sm"
                class="truncate text-zinc-900 dark:text-white">
                {{ $leader->name }}
            </flux:heading>

            <flux:text
                class="truncate text-xs md:text-sm text-zinc-500 dark:text-zinc-400">
                {{ $leader->bio ?? 'No bio yet' }}
            </flux:text>

        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="text-right shrink-0">

        <div class="text-emerald-600 dark:text-emerald-400 font-bold text-lg md:text-xl">
            +{{ $leader->points }}
        </div>

        <flux:text class="hidden sm:block text-xs text-zinc-400">
            points
        </flux:text>

    </div>

    </div>

    @endforeach

</flux:card>