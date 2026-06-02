<flux:navbar class="flex items-center gap-2 text-zinc-500 dark:text-zinc-400 px-6">

    <flux:navbar.item
        href="{{ $backUrl }}"
        wire:navigate>

        <flux:icon.arrow-uturn-left variant="micro" />

    </flux:navbar.item>
    <flux:heading size="lg">
        {{ $title }}
    </flux:heading>

</flux:navbar>