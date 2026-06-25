@props(['course'])
<x-landing.card-wrapper>
    <flux:card class="h-full flex flex-col bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
        <!-- Thumbnail -->
        <div class="overflow-hidden rounded-xl">
            <img src="{{ asset('storage/'.$course->thumbnail) }}" class="w-full h-48 object-cover transition-transform duration-500 hover:scale-105">
        </div>
        <div class="mt-5 flex flex-col flex-1">
            <!-- Title -->
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white line-clamp-2">
                {{ $course->title }}
            </h3>
            <!-- Description -->
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-3 min-h-[60px]">
                {{ Str::limit(strip_tags($course->description), 80) }}
            </p>
            <!-- Stats -->
            <div class="flex flex-wrap gap-4 mt-5 text-sm text-zinc-500 dark:text-zinc-400">
                <div class="flex items-center gap-1">
                    <flux:icon.users class="size-4" />
                    <span>
                        {{ $course->enrollments_count }}
                    </span>
                </div>
                <div class="flex items-center gap-1">
                    <flux:icon.folder class="size-4" />
                    <span>
                        {{ $course->modules_count }} Modul
                    </span>
                </div>
                <div class="flex items-center gap-1">
                    <flux:icon.play-circle class="size-4" />
                    <span>
                        {{ $course->lessons_count }} Lesson
                    </span>
                </div>
            </div>
            <!-- Footer -->
            <div class="mt-auto pt-6 flex items-center justify-end">
                <span class="font-bold text-lg text-emerald-500">
                    Rp {{ number_format($course->price,0,',','.') }}
                </span>
            </div>
        </div>
    </flux:card>
</x-landing.card-wrapper>