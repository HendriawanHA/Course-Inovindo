@props([
    'model' => 'search',
    'name' => 'search',
    'value' => '',
    'placeholder' => 'Cari...',
    'action' => null,
    'livewire' => true,
    'clearUrl' => null,
])

@php
    $hasValue = filled($livewire ? null : $value);
@endphp

@if ($livewire)
    <div class="rounded-3xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-zinc-900 sm:p-4">
        <div class="flex items-center gap-3">
            <flux:icon.magnifying-glass class="size-5 shrink-0 text-zinc-400" />
            <input
                type="search"
                data-instructor-search
                wire:model.live.debounce.300ms="{{ $model }}"
                placeholder="{{ $placeholder }}"
                class="min-w-0 flex-1 border-0 bg-transparent p-0 text-sm text-zinc-900 placeholder:text-zinc-400 focus:ring-0 dark:text-white dark:placeholder:text-zinc-500">

            <button
                type="button"
                wire:click="clearSearch"
                wire:show="{{ $model }}"
                class="rounded-full px-3 py-1.5 text-xs font-semibold text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white">
                Clear
            </button>

            <kbd class="hidden rounded-lg border border-zinc-200 px-2 py-1 text-[11px] font-semibold text-zinc-400 dark:border-zinc-700 sm:inline-flex">Ctrl K</kbd>
        </div>
    </div>
@else
    <form method="GET" action="{{ $action }}" class="rounded-3xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-zinc-900 sm:p-4">
        <div class="flex items-center gap-3">
            <flux:icon.magnifying-glass class="size-5 shrink-0 text-zinc-400" />
            <input
                type="search"
                name="{{ $name }}"
                value="{{ $value }}"
                data-instructor-search
                placeholder="{{ $placeholder }}"
                class="min-w-0 flex-1 border-0 bg-transparent p-0 text-sm text-zinc-900 placeholder:text-zinc-400 focus:ring-0 dark:text-white dark:placeholder:text-zinc-500">

            @if ($hasValue && $clearUrl)
                <a href="{{ $clearUrl }}" class="rounded-full px-3 py-1.5 text-xs font-semibold text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white">
                    Clear
                </a>
            @endif

            <button type="submit" class="rounded-full bg-indigo-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-indigo-500">
                Search
            </button>

            <kbd class="hidden rounded-lg border border-zinc-200 px-2 py-1 text-[11px] font-semibold text-zinc-400 dark:border-zinc-700 sm:inline-flex">Ctrl K</kbd>
        </div>
    </form>
@endif
