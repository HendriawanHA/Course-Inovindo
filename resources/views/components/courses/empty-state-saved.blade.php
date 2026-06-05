<div class="flex flex-col items-center justify-center text-center py-24">
    <div class="w-20 h-20 rounded-3xl
                    bg-indigo-500/10
                    flex items-center justify-center mb-6">
        <flux:icon.bookmark
            class="w-10 h-10 text-blue-600" />
    </div>
    <flux:heading
        size="lg"
        class="text-zinc-900 dark:text-white">
        No courses yet
    </flux:heading>
    <flux:text
        class="mt-3 max-w-md text-zinc-500 dark:text-zinc-400 leading-relaxed">
        You haven't joined or bookmarked any courses yet.
        Explore available courses and start learning.
    </flux:text>
    <a
        href="{{ route('courses.index') }}"
        wire:navigate
        class="mt-8">
        <flux:button variant="filled">
            Explore Courses
        </flux:button>
    </a>
</div>