@props([
'course',
'mode' => 'default'
])

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

<div
    class="group relative">
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

    @if ($course->can_access)
    <a
        href="{{ route('courses.show', $course->id) }}"
        wire:navigate>
        @else
        <div
            @click="$dispatch('open-buy-modal', @js($buyModalData))"
            class="cursor-pointer">
            @endif
            <div class="bg-zinc-50 dark:bg-zinc-900
                            border border-zinc-500/50 dark:border-zinc-800
                            rounded-2xl overflow-hidden
                            hover:border-zinc-300 dark:hover:border-zinc-700
                            hover:shadow-xl transition-all duration-200">
                <div class="aspect-video bg-zinc-900 relative overflow-hidden">
                    <img
                        src="{{ $course->thumbnail_url }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        alt="{{ $course->title }}" />
                    <div class="absolute inset-0
                                    bg-gradient-to-t
                                    from-black/20 via-black/10 to-transparent">
                    </div>
                    <x-courses.status-badge :course="$course"
                        :mode="'default'" />
                </div>
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
                    @if($mode === 'saved')
                    <div class="mt-4">
                        @if($course->can_access)
                        @if($course->is_completed)
                        <flux:button
                            variant="ghost"
                            class="w-full rounded-xl">
                            Review Course
                        </flux:button>
                        @elseif($course->progress > 0 && $course->next_lesson)
                        <flux:button
                            href="{{ route('courses.video', [
                                                        'course' => $course->id,
                                                        'lesson' => $course->next_lesson->id,
                                                        'back' => route('courses.saved')
                                                    ]) }}"
                            wire:navigate
                            variant="primary"
                            class="w-full rounded-xl !text-white !bg-blue-700 hover:!bg-blue-600 font-medium shadow-lg shadow-blue-500/20 transition-all duration-200">
                            Continue Learning
                        </flux:button>
                        @elseif($course->first_lesson)
                        <flux:button
                            href="{{ route('courses.video', [
                                                        'course' => $course->id,
                                                        'lesson' => $course->first_lesson->id,
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
                            @click.stop="$dispatch('open-buy-modal', @js($buyModalData))"
                            class="w-full rounded-xl bg-amber-500 hover:bg-amber-400 text-white py-2.5 text-sm font-medium transition-all duration-200">
                            Unlock Course
                        </button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @if ($course->can_access)
    </a>
    @else
</div>
@endif
</div>