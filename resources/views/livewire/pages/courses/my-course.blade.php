<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-50 dark:bg-zinc-900 min-h-screen">

        <!-- Header -->
        <div class="mb-6">

            <flux:heading
                size="xl"
                class="flex items-center gap-2 text-zinc-900 dark:text-white">

                <flux:icon.bookmark variant="solid" class="size-6 text-indigo-500" />

                My Courses

            </flux:heading>

            <flux:text class="mt-2 text-zinc-500 dark:text-zinc-400">
                Courses you saved or joined will appear here.
            </flux:text>

        </div>

        <flux:separator class="mb-8" />

        @if ($courses->isEmpty())

        <!-- EMPTY STATE -->
        <div class="flex flex-col items-center justify-center text-center py-24">

            <div class="w-20 h-20 rounded-3xl
                bg-indigo-500/10
                flex items-center justify-center mb-6">

                <flux:icon.bookmark
                    class="w-10 h-10 text-indigo-500" />

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

                <flux:button variant="primary" color="indigo">

                    Explore Courses

                </flux:button>

            </a>

        </div>

        @else

        <!-- GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @foreach ($courses as $course)

            <!-- nanti isi course card -->

            @endforeach

        </div>

        @endif

    </flux:main>
</x-app-layout>