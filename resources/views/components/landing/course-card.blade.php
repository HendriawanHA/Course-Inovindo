@props(['course'])

<x-landing.card-wrapper>
    <flux:card class="h-full flex flex-col !shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">

        <img
            src="{{ asset('storage/'.$course->thumbnail) }}"
            class="w-full h-48 object-cover rounded-xl">

        <div class="mt-4 flex flex-col flex-1">

            <h3 class="font-semibold text-lg">
                {{ $course->title }}
            </h3>

            <p class="text-sm text-zinc-500 mt-2 min-h-[60px]">
                {{ Str::limit($course->description, 80) }}
            </p>

            <div class="flex flex-wrap gap-4 mt-4 text-sm text-zinc-500">

                <div class="flex items-center gap-1">
                    <flux:icon.users class="size-4" />
                    <span>{{ $course->enrollments_count }}</span>
                </div>

                <div class="flex items-center gap-1">
                    <flux:icon.folder class="size-4" />
                    <span>{{ $course->modules_count }} Modules</span>
                </div>

                <div class="flex items-center gap-1">
                    <flux:icon.play-circle class="size-4" />
                    <span>{{ $course->lessons_count }} Lessons</span>
                </div>

            </div>

            <div class="flex justify-end items-center mt-auto pt-5">

                <span class="font-bold text-emerald-500">
                    Rp {{ number_format($course->price,0,',','.') }}
                </span>

            </div>

        </div>

    </flux:card>
</x-landing.card-wrapper>