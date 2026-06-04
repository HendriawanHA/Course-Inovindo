<flux:heading size="lg" class="md:!text-2xl mb-5 text-zinc-900 dark:text-white !font-bold">
    {{ $events->first()?->start_time->translatedFormat('F Y') }}
</flux:heading>