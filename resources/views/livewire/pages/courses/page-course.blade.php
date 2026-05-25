<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-50 dark:bg-zinc-900 min-h-screen">

        <!-- Page Header -->
        <div class="mb-6">
            <flux:heading size="xl" class="flex items-center gap-2 text-zinc-900 dark:text-white">
                <flux:icon.book-open variant="solid" class=" size-6" />
                Courses
            </flux:heading>
        </div>

        <flux:separator class="mb-8" />

        <!-- Filter Tabs -->
        <div class="flex gap-2 mb-8">
            <a href="{{ route('courses.index') }}">
                <flux:button
                    variant="{{ request('search') ? 'ghost' : 'filled' }}"
                    class="rounded-full">
                    All Courses
                </flux:button>
            </a>
            <flux:button
                variant="ghost"
                class="rounded-full">
                My Courses
            </flux:button>
        </div>

        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @foreach ($courses as $course)
            <a href="{{ route('courses.show', $course->id) }}" class="group">
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 
                            rounded-2xl overflow-hidden hover:border-zinc-300 dark:hover:border-zinc-700 
                            hover:shadow-lg transition-all duration-200">

                    <!-- Thumbnail -->
                    <div class="aspect-video bg-zinc-900 relative overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $course->thumbnail) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="{{ $course->title }}" />
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        <flux:heading size="sm" class="text-zinc-900 dark:text-white font-semibold leading-tight line-clamp-2">
                            {{ $course->title }}
                        </flux:heading>

                        <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-widest mt-3">
                            {{ $course->category ?? 'Course' }}
                        </flux:text>

                        <!-- Progress -->
                        <div class="mt-6">
                            <div class="flex justify-between text-xs mb-1.5">
                                @php

                                $enrollment = $course->enrollments->first();

                                $progress = $enrollment?->progress ?? 0;

                                @endphp

                                <span class="text-zinc-500 dark:text-zinc-400">
                                    {{ $progress }}% Complete
                                </span>
                            </div>
                            <div class="w-full bg-zinc-200 dark:bg-zinc-800 h-1.5 rounded-full overflow-hidden">
                                <div
                                    class="bg-blue-700 dark:bg-blue-600 h-full transition-all duration-500"
                                    style="width: {{ $progress }}%">
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mt-4 flex items-center gap-2">
                            @if (!$course->is_published)
                            <flux:icon.lock-closed variant="micro" class="text-amber-500" />
                            <span class="text-xs font-medium text-amber-500">Private Course</span>
                            @else
                            <flux:icon.eye variant="micro" class="text-emerald-500" />
                            <span class="text-xs font-medium text-emerald-500">Published</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            @endforeach

        </div>

    </flux:main>
</x-app-layout>