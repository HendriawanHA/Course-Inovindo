<div class="px-4 md:px-8 mt-8 md:mt-10">

    <div class="flex items-center justify-between gap-3 mb-6">

        <flux:heading size="lg">
            Most Popular Courses
        </flux:heading>

        <flux:link href="{{ route('courses.index') }}" wire:navigate>
            View all
        </flux:link>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-5">

        @foreach ($topCourses as $index => $course)

        @php
        $buyModalData = [
        'id' => $course->id,
        'title' => addslashes($course->title),
        'thumbnail' => $course->thumbnail_url,
        'price' => number_format($course->price, 0, ',', '.'),
        'avatar' => $course->instructor->avatar_url ?? '',
        'instructor' => $course->instructor->name ?? 'Unknown Instructor',
        'modules' => $course->modules->count(),
        'lessons' => $course->lessons->count(),
        'buyUrl' => route('courses.buy', $course->id),
        ];
        @endphp

        @if($course->can_access)

        <a href="{{ route('courses.show', $course->id) }}" wire:navigate>

            @else

            <div
                @click="$dispatch('open-buy-modal', @js($buyModalData))"
                class="cursor-pointer">

                @endif

                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 
                            rounded-2xl overflow-hidden hover:border-zinc-300 dark:hover:border-zinc-700 shadow-sm
                            hover:shadow-lg transition-all duration-200">

                    <div class="aspect-video bg-zinc-900 relative overflow-hidden">
                        <img
                            src="{{ $course->thumbnail_url }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="{{ $course->title }}" />
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        <div
                            class="inline-flex items-center px-2 py-1 rounded-full
    bg-amber-500/10 text-amber-500 text-xs font-semibold mb-3">

                            #{{ $index + 1 }} Popular

                        </div>
                        <flux:heading size="sm" class="text-zinc-900 dark:text-white font-semibold leading-tight line-clamp-2">
                            {{ $course->title }}
                        </flux:heading>

                        <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-widest mt-3">
                            {{ $course->category ?? 'Course' }}
                        </flux:text>

                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $course->enrollments_count }} Students
                        </p>

                    </div>

                </div>

                @if ($course->can_access)
        </a>
        @else
    </div>
    @endif

    @endforeach
</div>