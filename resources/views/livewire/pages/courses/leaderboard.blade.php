<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-100 dark:bg-zinc-900">

        <!-- Page Header -->
        <div class="mb-8">
            <flux:heading size="xl" class="flex items-center gap-2 text-zinc-900 dark:text-white">
                <flux:icon.trophy variant="solid" class=" size-6" />
                Leaderboard
            </flux:heading>
        </div>

        <flux:separator class="mb-10" />

        <div class="max-w-5xl mx-auto">
            @php

            $currentPoints = auth()->user()->points ?? 0;

            $ranks = [
            ['name' => 'Newbie', 'points' => 0],
            ['name' => 'Explorer', 'points' => 10],
            ['name' => 'Contributor', 'points' => 80],
            ['name' => 'Player', 'points' => 160],
            ['name' => 'Builder', 'points' => 320],
            ['name' => 'Catalyst', 'points' => 600],
            ['name' => 'Operator', 'points' => 900],
            ['name' => 'Pro', 'points' => 1800],
            ['name' => 'Legend', 'points' => 3000],
            ];

            $currentRank = collect($ranks)
            ->filter(fn ($rank) => $currentPoints >= $rank['points'])
            ->last();

            $currentLevel = collect($ranks)
            ->search($currentRank) + 1;

            $nextRank = $ranks[$currentLevel] ?? null;

            @endphp

            <!-- Hero Top Rank -->
            <flux:card class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 shadow-xl">
                <div class="flex items-start justify-between">
                    <!-- Left Profile -->
                    <div class="flex items-start gap-5">
                        <div class="relative">
                            <flux:avatar
                                size="xl"
                                circle
                                src="{{ auth()->user()->avatar
        ? asset('storage/' . auth()->user()->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" />
                            <div class="absolute -bottom-1 -right-1">
                                <div class="w-8 h-8 rounded-full bg-amber-500 text-black text-sm font-bold flex items-center justify-center border-4 border-white dark:border-zinc-900">
                                    {{ $currentLevel }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <flux:heading size="xl" class="text-zinc-900 dark:text-white">
                                {{ auth()->user()->name }}
                            </flux:heading>
                            <flux:text class="text-zinc-500 dark:text-zinc-400 mt-1">
                                {{ auth()->user()->points ?? 0 }} points
                            </flux:text>
                        </div>
                    </div>

                    <!-- Right Level -->
                    <div class="text-right">
                        <flux:badge color="amber" class="rounded-full px-5 py-2 gap-2 text-sm font-medium">
                            <flux:icon.trophy variant="mini" />
                            Level {{ $currentLevel }}
                            <flux:separator vertical />
                            {{ $currentRank['name'] }}
                        </flux:badge>
                        <div class="flex items-center justify-end gap-2 mt-4">
                            <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">

                                @if ($nextRank)
                                {{ $nextRank['points'] - $currentPoints }} points to level up
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
                    @foreach ($ranks as $index => $rank)
                    @php
                    $active = $currentPoints >= $rank['points'];
                    @endphp <div class="flex items-center gap-4">
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
                            <flux:heading size="sm" class="{{ $active ? 'text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400' }}">
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

            <!-- Filters -->
            <div class="flex items-center justify-between mt-10 mb-6">
                <div class="flex gap-2">
                    <flux:button variant="filled" class="rounded-full">7 days</flux:button>
                    <flux:button variant="ghost" class="rounded-full">30 days</flux:button>
                    <flux:button variant="ghost" class="rounded-full">All time</flux:button>
                </div>
                <flux:text class="text-zinc-500 dark:text-zinc-400 text-sm cursor-pointer hover:text-zinc-700 dark:hover:text-zinc-300">
                    How do points work?
                </flux:text>
            </div>

            <!-- Leaderboard List -->
            <flux:card class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl overflow-hidden divide-y divide-zinc-200 dark:divide-zinc-800 shadow-xl">

                @foreach ($leaders as $index => $leader)

                <div class="flex items-center justify-between p-5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">

                    <div class="flex items-center gap-5">

                        <!-- Rank -->
                        <div class="w-10 text-center">

                            @if ($index < 3)

                                <div class="w-9 h-9 rounded-full bg-amber-500 text-black font-bold flex items-center justify-center text-lg">
                                {{ $index + 1 }}
                        </div>

                        @else

                        <div class="text-xl font-bold text-zinc-400 dark:text-zinc-500">
                            {{ $index + 1 }}
                        </div>

                        @endif

                    </div>

                    <!-- Avatar -->
                    <flux:avatar
                        size="md"
                        circle
                        src="{{ $leader->avatar
                    ? asset('storage/' . $leader->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($leader->name) }}" />

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

                <!-- Points -->
                <div class="text-right">

                    <div class="text-emerald-600 dark:text-emerald-400 font-bold text-xl">
                        +{{ $leader->points }}
                    </div>

                    <flux:text class="text-xs text-zinc-400">
                        points
                    </flux:text>

                </div>

        </div>

        @endforeach

        </flux:card>

        </div>
    </flux:main>
</x-app-layout>