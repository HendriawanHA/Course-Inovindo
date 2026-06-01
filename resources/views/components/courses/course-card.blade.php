<div
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
                                {{ $course->is_bookmarked
                                    ? 'text-blue-700 dark:text-blue-400'
                                    : 'text-zinc-400 dark:text-zinc-500'
                                }}
                                hover:text-blue-500" />

        </button>

    </form>

    <!-- CARD -->
    @if ($course->can_access)

    <a
        href="{{ route('courses.show', $course->id) }}"
        wire:navigate>

        @else

        <div
            @click="$dispatch('open-buy-modal', {
        id: {{ $course->id }},
        title: '{{ addslashes($course->title) }}',
        thumbnail: '{{ $course->thumbnail_url }}',
        price: '{{ number_format($course->price,0,',','.') }}',
        avatar: '{{ $course->instructor->avatar_url ?? '' }}',
        instructor: '{{ $course->instructor->name ?? 'Unknown Instructor' }}',
        modules: '{{ $course->modules->count() }}',
        lessons: '{{ $course->lessons->count() }}',
        buyUrl: '{{ route('courses.buy', $course->id) }}'
    })"
            class="cursor-pointer">

            @endif

            <div class="bg-zinc-50 dark:bg-zinc-900
                            border border-zinc-500/50 dark:border-zinc-800
                            rounded-2xl overflow-hidden
                            hover:border-zinc-300 dark:hover:border-zinc-700
                            hover:shadow-xl transition-all duration-200">

                <!-- Thumbnail -->
                <div class="aspect-video bg-zinc-900 relative overflow-hidden">

                    <img
                        src="{{ $course->thumbnail_url }}"
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
                                {{ $course->progress }}% Complete
                            </span>

                        </div>

                        <div class="w-full bg-zinc-200 dark:bg-zinc-800 h-1.5 rounded-full overflow-hidden">

                            <div
                                class="bg-blue-700 dark:bg-blue-600 h-full transition-all duration-500"
                                style="width: {{ $course->progress }}%">
                            </div>

                        </div>

                    </div>

                    <!-- Status -->
                    <div class="mt-4 flex items-center justify-between">

                        @if ($course->price > 0)

                        @if ($course->has_purchased)

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

            @if ($course->can_access)
    </a>
    @else
</div>


@endif

</div>