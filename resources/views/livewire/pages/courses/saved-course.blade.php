<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-100 dark:bg-zinc-900">

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

                <flux:button variant="primary" color="blue">

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

            $isCompleted = $progress >= 100;

            $nextLesson = $course->getNextLessonForUser(auth()->user());

            $firstLesson = $course->firstLesson();

            $isBookmarked = auth()->user()
            ->bookmarkedCourses
            ->contains($course->id);

            $hasPurchased = auth()->check()
            ? $course->isPurchasedBy(auth()->user())
            : false;

            $canAccess = $course->isFree() || $hasPurchased;

            @endphp

            <div
                x-data="{ openBuyModal: false }"
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
                @if ($canAccess)

                <a
                    href="{{ route('courses.show', [
                                    'id' => $course->id,
                                    'back' => route('courses.saved')
                                ]) }}"
                    wire:navigate>

                    @else

                    <div
                        @click="openBuyModal = true"
                        class="cursor-pointer">

                        @endif

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

                            <!-- Title -->
                            <flux:heading
                                size="sm"
                                class="text-zinc-900 dark:text-white font-semibold leading-tight line-clamp-2">

                                {{ $course->title }}

                            </flux:heading>

                            <!-- Category -->
                            <flux:text
                                class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-widest mt-3">

                                {{ $course->category ?? 'Course' }}

                            </flux:text>

                            <!-- Progress -->
                            <div class="mt-6">

                                <div class="flex justify-between text-xs mb-1.5">

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

                            <!-- STATUS -->
                            <div class="mt-4 flex items-center justify-between">

                                @if ($course->price > 0)

                                @if ($hasPurchased)

                                <div class="flex items-center gap-2">

                                    <flux:icon.check-circle
                                        variant="micro"
                                        class="text-emerald-500" />

                                    <span class="text-xs font-medium text-emerald-500">
                                        Purchased
                                    </span>

                                </div>

                                @else

                                <div class="flex items-center gap-2">

                                    <flux:icon.lock-closed
                                        variant="micro"
                                        class="text-amber-500" />

                                    <span class="text-xs font-medium text-amber-500">
                                        Paid Course
                                    </span>

                                </div>

                                <span class="text-sm font-bold text-zinc-900 dark:text-white">
                                    Rp{{ number_format($course->price, 0, ',', '.') }}
                                </span>

                                @endif

                                @else

                                <div class="flex items-center gap-2">

                                    <flux:icon.eye
                                        variant="micro"
                                        class="text-emerald-500" />

                                    <span class="text-xs font-medium text-emerald-500">
                                        Free Course
                                    </span>

                                </div>

                                @endif

                            </div>

                            <!-- CTA -->
                            <div class="mt-6">

                                @if($canAccess)

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
                                                    'lesson' => $firstLesson->id,
                                                    'back' => route('courses.saved')
                                                ]) }}"
                                    wire:navigate
                                    variant="primary"
                                    class="w-full rounded-xl !text-white !bg-emerald-500 hover:!bg-emerald-400 font-medium shadow-lg shadow-emerald-500/20 transition-all duration-200">

                                    Start Course

                                </flux:button>

                                @endif

                                @else

                                <button
                                    @click="openBuyModal = true"
                                    class="w-full rounded-xl bg-amber-500 hover:bg-amber-400 text-white py-2.5 text-sm font-medium transition-all duration-200">

                                    Unlock Course

                                </button>

                                @endif

                            </div>

                        </div>

                        @if ($canAccess)

                </a>

                @else

            </div>

            @endif

            <!-- BUY MODAL -->
            <div
                x-show="openBuyModal"
                x-transition
                class="fixed inset-0 z-50 flex items-center justify-center p-4">

                <!-- Overlay -->
                <div
                    @click="openBuyModal = false"
                    class="absolute inset-0 bg-black/60 backdrop-blur-sm">
                </div>

                <!-- Modal -->
                <div
                    @click.stop
                    class="relative w-full max-w-md rounded-3xl
                            bg-white dark:bg-zinc-900
                            border border-zinc-200 dark:border-zinc-800
                            p-6 shadow-2xl">

                    <!-- Header -->
                    <div class="flex items-start justify-between">

                        <div>

                            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                                Purchase Course
                            </h2>

                            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                                Unlock all lessons and premium content.
                            </p>

                        </div>

                        <button
                            @click="openBuyModal = false"
                            class="text-zinc-400 hover:text-zinc-600">

                            ✕

                        </button>

                    </div>

                    <!-- Course -->
                    <div class="mt-6">

                        <!-- Thumbnail -->
                        <div class="aspect-video bg-zinc-900 relative overflow-hidden">

                            <img
                                src="{{ asset('storage/' . $course->thumbnail) }}"
                                class="w-full h-full  object-cover"
                                alt="{{ $course->title }}" />

                            <div class="absolute rounded border-2 border-zinc-500/40 inset-0
                                    bg-gradient-to-t
                                    from-black/20 via-black/10 to-transparent">
                            </div>

                        </div>

                        <!-- Title -->
                        <h3 class="mt-4 font-semibold text-zinc-900 dark:text-white text-lg">
                            {{ $course->title }}
                        </h3>

                        <!-- Instructor -->
                        <div class="mt-3 flex items-center gap-2">

                            <div class="w-8 h-8 rounded-full bg-blue-100
                    flex items-center justify-center
                    text-blue-700 font-semibold text-sm">

                                {{ strtoupper(substr($course->instructor->name ?? 'U', 0, 1)) }}
                            </div>

                            <div>

                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    Instructor
                                </p>

                                <p class="text-sm font-medium text-zinc-900 dark:text-white">
                                    {{ $course->instructor->name ?? 'Unknown Instructor' }}
                                </p>

                            </div>

                        </div>

                        <!-- Stats -->
                        <div class="mt-5 grid grid-cols-2 gap-3">

                            <!-- Modules -->
                            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 p-4">

                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    Modules
                                </p>

                                <p class="mt-1 text-lg font-bold text-zinc-900 dark:text-white">
                                    {{ $course->modules->count() }}
                                </p>

                            </div>

                            <!-- Lessons -->
                            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 p-4">

                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    Lessons
                                </p>

                                <p class="mt-1 text-lg font-bold text-zinc-900 dark:text-white">
                                    {{ $course->lessons->count() }}
                                </p>

                            </div>

                        </div>

                        <!-- Price -->
                        <div class="mt-6 flex items-center justify-between">

                            <div>

                                <p class="text-xs uppercase tracking-widest
                    text-zinc-500 dark:text-zinc-400">

                                    Price

                                </p>

                                <p class="mt-1 text-3xl font-bold text-blue-700">
                                    Rp{{ number_format($course->price, 0, ',', '.') }}
                                </p>

                            </div>

                            <div class="px-4 py-2 rounded-full
                    bg-amber-500/10
                    text-amber-500
                    text-sm font-semibold">

                                Premium

                            </div>

                        </div>

                    </div>

                    <!-- Button -->
                    <form
                        method="POST"
                        action="{{ route('courses.buy', $course->id) }}"
                        class="mt-6">

                        @csrf

                        <button
                            type="submit"
                            class="w-full rounded-2xl
                                    bg-blue-700
                                    hover:bg-blue-600
                                    text-white
                                    py-3
                                    font-semibold
                                    transition-all">

                            Confirm Purchase

                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endforeach

        </div>

        @endif

    </flux:main>
</x-app-layout>