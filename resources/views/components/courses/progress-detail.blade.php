@props([
'completedLessons',
'totalLessons',
'progress',
])
<flux:heading size="lg">Progress</flux:heading>
<div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8 rounded-2xl mb-10 shadow-sm">

    <div class="flex justify-between items-center mb-4">
        <flux:text class="text-sm">
            Completed {{ $completedLessons }} of {{ $totalLessons }} lessons
        </flux:text>

        <span class="font-bold text-zinc-900 dark:text-white">
            {{ $progress }}%
        </span>
    </div>

    <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-2.5 rounded-full overflow-hidden">
        <div
            class="bg-blue-700 h-full transition-all duration-500"
            style="width: {{ $progress }}%">
        </div>
    </div>

</div>