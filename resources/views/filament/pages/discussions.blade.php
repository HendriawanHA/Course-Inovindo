<x-filament-panels::page>
    <div class="mb-6 space-y-4">
        <div class="relative max-w-md">
            <x-filament::input.wrapper>
                <x-filament::input
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari course..."
                />
            </x-filament::input.wrapper>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <span class="rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                {{ $courses->count() }} courses
            </span>
            <span class="rounded-full bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                {{ $totalDiscussions }} total diskusi
            </span>
        </div>
    </div>

    @if ($courses->isEmpty())
        <div class="rounded-xl border border-dashed border-gray-300 p-12 text-center dark:border-gray-600">
            <p class="text-gray-500 dark:text-gray-400">
                {{ $search ? 'Tidak ada course dengan kata kunci "' . $search . '".' : 'Belum ada course.' }}
            </p>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($courses as $c)
                <a
                    href="{{ \App\Filament\Pages\DiscussionsView::getUrl(['course' => $c->id]) }}"
                    class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-indigo-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-indigo-500/50"
                >
                    <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 dark:text-white dark:group-hover:text-indigo-400">
                        {{ Str::limit($c->title, 50) }}
                    </h3>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ $c->instructor?->name ?? 'Unknown' }}
                        &middot;
                        @if ($c->is_published)
                            <span class="text-emerald-600 dark:text-emerald-400">Published</span>
                        @else
                            <span class="text-amber-600 dark:text-amber-400">Draft</span>
                        @endif
                    </p>

                    <div class="mt-4 flex flex-wrap items-center gap-3 text-sm">
                        <span class="rounded-lg bg-gray-100 px-2.5 py-1 font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                            {{ $c->discussions_count }} diskusi
                        </span>

                        @if ($c->unanswered_count > 0)
                            <span class="rounded-lg bg-amber-100 px-2.5 py-1 font-medium text-amber-700 dark:bg-amber-500/15 dark:text-amber-300">
                                {{ $c->unanswered_count }} belum
                            </span>
                        @endif
                    </div>

                    @if ($c->latest_activity_at)
                        <p class="mt-3 text-xs text-gray-400 dark:text-gray-500">
                            Aktivitas terakhir {{ \Carbon\Carbon::parse($c->latest_activity_at)->diffForHumans() }}
                        </p>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</x-filament-panels::page>
