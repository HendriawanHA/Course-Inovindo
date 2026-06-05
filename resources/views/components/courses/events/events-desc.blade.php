@props(['event'])
<flux:heading
    size="xl"
    class="text-2xl md:text-4xl leading-tight break-words text-zinc-900 dark:text-white !font-bold">
    {{ $event->title }}
</flux:heading>

<flux:heading size="lg" class="mt-10 mb-3 text-zinc-900 dark:text-white !font-bold">
    Details
</flux:heading>

<flux:text
    class="text-lg md:text-xl font-semibold text-zinc-700 dark:text-zinc-300">
    {{ $event->event_type }}
</flux:text>

<div
    class="prose dark:prose-invert max-w-none text-justify prose-p:my-1 prose-li:my-0 prose-headings:mb-2 prose-headings:mt-4">
    {!! $event->description !!}
</div>