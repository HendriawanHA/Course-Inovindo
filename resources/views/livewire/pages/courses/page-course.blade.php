<x-app-layout>
    <flux:main class="flex-1 p-8 bg-zinc-50 dark:bg-zinc-900 min-h-screen">

        <!-- Page Header -->
        <div class="mb-6">
            <flux:heading size="xl" class="flex items-center gap-2 text-zinc-900 dark:text-white">
                <flux:icon.book-open variant="solid" class="size-6" />
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

            @php
            $isBookmarked = auth()->user()
            ->bookmarkedCourses
            ->contains($course->id);

            $enrollment = $course->enrollments
            ->where('user_id', auth()->id())
            ->first();

            $progress = $enrollment?->progress ?? 0;

            $hasPurchased = auth()->check()
            ? $course->isPurchasedBy(auth()->user())
            : false;

            $canAccess = $course->isFree() || $hasPurchased;
            @endphp

            <div
                x-data="{ openBuyModal: false }"
                class="group relative">

                <!-- Bookmark -->
                <form
                    method="POST"
                    action="{{ route('courses.bookmark', $course->id) }}"
                    class="absolute top-3 right-3 z-10">

                    @csrf

                    <button
                        type="submit"
                        class="flex items-center justify-center hover:scale-105 transition-all duration-200">

                        <flux:icon.bookmark
                            variant="solid"
                            class="w-5 h-5 transition-all duration-200
                                {{ $isBookmarked
                                    ? 'text-blue-700 dark:text-blue-400'
                                    : 'text-zinc-400 dark:text-zinc-500'
                                }}
                                hover:text-blue-500" />

                    </button>

                </form>

                <!-- CARD -->
                @if ($canAccess)

                <a
                    href="{{ route('courses.show', $course->id) }}"
                    wire:navigate>

                    @else

                    <div
                        @click="openBuyModal = true"
                        class="cursor-pointer">

                        @endif

                        <div class="bg-white dark:bg-zinc-900
                            border border-zinc-200 dark:border-zinc-800
                            rounded-2xl overflow-hidden
                            hover:border-zinc-300 dark:hover:border-zinc-700
                            hover:shadow-lg transition-all duration-200">

                            <!-- Thumbnail -->
                            <div class="aspect-video bg-zinc-900 relative overflow-hidden">

                                <img
                                    src="{{ asset('storage/' . $course->thumbnail) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    alt="{{ $course->title }}" />

                                <div class="absolute inset-0
                                    bg-gradient-to-t
                                    from-black/20 via-black/10 to-transparent">
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

                                <!-- Status -->
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

                            <div class="w-8 h-8 rounded-full bg-indigo-100
                    flex items-center justify-center
                    text-indigo-600 font-semibold text-sm">

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

                                <p class="mt-1 text-3xl font-bold text-indigo-600">
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
                                    bg-indigo-600
                                    hover:bg-indigo-500
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

    </flux:main>
</x-app-layout>