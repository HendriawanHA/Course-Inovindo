<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-100 dark:bg-zinc-900 min-h-screen">

        <!-- Header -->
        <div class="mb-6">

            <flux:heading
                size="xl"
                class="flex items-center gap-2 text-zinc-900 dark:text-white">

                <flux:icon.bookmark variant="solid" class="size-6 text-blue-700" />

                Saved Courses

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

            @php

            $enrollment = $course->enrollments
            ->where('user_id', auth()->id())
            ->first();

            $progress = $enrollment?->progress ?? 0;

            $completedLessons = auth()->user()
            ->completedLessons()
            ->whereIn(
            'lesson_id',
            $course->lessons->pluck('id')
            )
            ->count();

            $totalLessons = $course->lessons->count();

            $isCompleted =
            $progress >= 100;

            $nextLesson =
            $course->getNextLessonForUser(auth()->user());

            $firstLesson =
            $course->firstLesson();

            @endphp

            <div
                class="group relative bg-white dark:bg-zinc-900
        border border-zinc-200 dark:border-zinc-800
        rounded-2xl overflow-hidden
        hover:border-zinc-300 dark:hover:border-zinc-700
        hover:shadow-lg
        transition-all duration-200">

                <!-- BOOKMARK -->
                <form
                    method="POST"
                    action="{{ route('courses.bookmark', $course->id) }}"
                    class="absolute top-3 right-3 z-20">

                    @csrf

                    @php

                    $isBookmarked = auth()->user()
                    ->bookmarkedCourses
                    ->contains($course->id);

                    @endphp

                    <button
                        type="submit"
                        class="flex items-center justify-center
        hover:scale-105
        transition-all duration-200">

                        <flux:icon.bookmark
                            variant="solid"
                            class="w-5 h-5 transition-all duration-200

                    {{ $isBookmarked
                        ? 'text-blue-700 dark:text-blue-600'
                        : 'text-zinc-400 dark:text-zinc-500'
                    }}

                    hover:text-blue-500" />

                    </button>

                </form>

                <!-- CARD LINK -->
                <a
                    href="{{ route('courses.show', [
    'id' => $course->id,
    'back' => route('courses.saved')
]) }}"
                    wire:navigate>

                    <!-- Thumbnail -->
                    <div class="aspect-video bg-zinc-900 overflow-hidden relative">

                        <img
                            src="{{ asset('storage/' . $course->thumbnail) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="{{ $course->title }}" />

                        <div class="absolute inset-0
                    bg-gradient-to-t
                    from-black/20 via-black/10 to-transparent">
                        </div>

                        <!-- Status Badge -->
                        <div class="absolute bottom-3 left-3">

                            @if($isCompleted)

                            <div class="px-3 py-1 rounded-full
                        bg-emerald-500/90
                        text-white text-xs font-semibold
                        backdrop-blur-xl">

                                Completed

                            </div>

                            @elseif($progress > 0)

                            <div class="px-3 py-1 rounded-full
                        bg-blue-600/90
                        text-white text-xs font-semibold
                        backdrop-blur-xl">

                                In Progress

                            </div>

                            @else

                            <div class="px-3 py-1 rounded-full
                        bg-zinc-900/80
                        text-white text-xs font-semibold
                        backdrop-blur-xl">

                                Saved

                            </div>

                            @endif

                        </div>

                    </div>

                    <!-- Content -->
                    <div class="p-5">

                        <flux:heading
                            size="sm"
                            class="text-zinc-900 dark:text-white font-semibold leading-tight line-clamp-2">

                            {{ $course->title }}

                        </flux:heading>

                        <flux:text
                            class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-widest mt-3">

                            {{ $course->category ?? 'Course' }}

                        </flux:text>

                        <!-- Progress -->
                        <div class="mt-6">

                            <div class="flex justify-between text-xs mb-1.5">

                                @php

                                $enrollment = $course->enrollments
                                ->where('user_id', auth()->id())
                                ->first();

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

                        <!-- CTA -->
                        <div class="mt-6">

                            @if($isCompleted)

                            <flux:button
                                variant="ghost"
                                class="w-full rounded-xl">

                                Review Course

                            </flux:button>

                            @elseif($progress > 0 && $nextLesson)

                            <flux:button
                                href="{{ route('courses.video', [
    'course' => $course->id,
    'lesson' => $nextLesson->id,
    'back' => route('courses.saved')
]) }}"
                                wire:navigate
                                variant="primary"
                                class="w-full rounded-xl !text-white !bg-blue-700 hover:!bg-blue-600 font-medium shadow-lg shadow-blue-500/20 transition-all duration-200">

                                Continue Learning

                            </flux:button>

                            @elseif($firstLesson)

                            <flux:button
                                href="{{ route('courses.video', [
    'course' => $course->id,
    'lesson' => $nextLesson->id,
    'back' => route('courses.saved')
]) }}"
                                wire:navigate
                                variant="primary"
                                class="w-full rounded-xl !text-white !bg-emerald-500 hover:!bg-emerald-400 font-medium shadow-lg shadow-blue-500/20 transition-all duration-200">

                                Start Course

                            </flux:button>

                            @endif

                        </div>

                    </div>

                </a>

            </div>

            @endforeach

        </div>

        @endif

    </flux:main>
</x-app-layout>