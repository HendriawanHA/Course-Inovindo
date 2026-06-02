<div class="mb-6">
    <flux:heading
        size="xl"
        class="flex items-center gap-2 text-zinc-900 dark:text-white">
        <flux:icon
            :name="$icon"
            variant="solid"
            class="size-6" />
        {{ $title }}
    </flux:heading>
    {{ $slot }}
</div>