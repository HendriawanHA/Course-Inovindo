<x-app-layout>
    <x-courses.detail-header
        :title="$course->title"
        :back-url="request('back', route('courses.index'))" />

    <flux:separator />

    <div class="max-w-4xl mx-auto mt-6 py-6 px-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-12">
            <flux:heading size="xl" class="text-3xl md:text-4xl">Welcome, {{ auth()->user()->name }}.</flux:heading>

            @php

            $firstLesson = $course->firstLesson();

            $totalLessons = $course->lessons()->count();

            $completedLessons = auth()->user()
            ->completedLessons()
            ->whereIn(
            'lesson_id',
            $course->lessons->pluck('id')
            )
            ->count();

            $hasStarted = $completedLessons > 0;

            $isCompleted = $completedLessons >= $totalLessons
            && $totalLessons > 0;

            /*
            |--------------------------------------------------------------------------
            | Cari lesson berikutnya yang belum selesai
            |--------------------------------------------------------------------------
            */

            $nextLesson = $course->getNextLessonForUser(
            auth()->user()
            );

            /*
            |--------------------------------------------------------------------------
            | Tentukan target lesson
            |--------------------------------------------------------------------------
            |
            | Kalau masih ada lesson belum selesai:
            | → lanjut ke lesson tersebut
            |
            | Kalau semua selesai:
            | → balik ke lesson pertama (review)
            |
            */

            $targetLesson = $nextLesson ?? $firstLesson;

            @endphp

            @if ($targetLesson)

            <flux:button
                href="{{ route('courses.video', [
    'course' => $course->id,
    'lesson' => $targetLesson->id,
    'back' => request()->fullUrl()
]) }}"
                wire:navigate
                variant="primary"
                class="!rounded-full hover:!text-white
    !border-2 border-blue-700/60 hover:bg-blue-700">

                @if($isCompleted)

                Review

                @elseif($hasStarted)

                Continue

                @else

                Start

                @endif

            </flux:button>

            @endif
        </div>

        <flux:heading size="lg" class="mb-4">Progress</flux:heading>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8 rounded-2xl mb-10 shadow-sm dark:shadow-none">
            <div class="flex justify-between items-end mb-4">
                @php

                $totalLessons = $course->lessons()->count();

                $completedLessons = auth()->user()
                ->completedLessons()
                ->whereIn(
                'lesson_id',
                $course->lessons->pluck('id')
                )
                ->count();

                $progress = $totalLessons > 0
                ? round(($completedLessons / $totalLessons) * 100)
                : 0;

                @endphp

                <flux:text class="text-sm">
                    Completed
                    {{ $completedLessons }}
                    of
                    {{ $totalLessons }}
                    lessons
                </flux:text>

                <span class="font-bold text-zinc-900 dark:text-white">
                    {{ $progress }}%
                </span>
            </div>
            <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-2.5 rounded-full overflow-hidden">
                @php

                $enrollment = auth()->user()
                ->enrollments
                ->where('course_id', $course->id)
                ->first();

                @endphp

                <div class="w-full bg-zinc-200 dark:bg-zinc-800 h-2.5 rounded-full overflow-hidden">

                    <div
                        class="bg-blue-700 dark:bg-blue-600 h-full transition-all duration-500"
                        style="width: {{ $progress }}%">
                    </div>

                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <div class="flex flex-col gap-1">
                    <flux:heading size="lg">Content</flux:heading>
                    <div class="flex items-center gap-2">
                        <flux:text variant="subtle" size="sm">{{ $course->modules->count() }} Modules</flux:text>
                        <flux:separator vertical small />
                        <flux:text variant="subtle" size="sm">{{ $course->modules->sum(fn ($m) => $m->lessons->count()) }} Lessons</flux:text>
                    </div>
                </div>
                <flux:button
                    variant="ghost"
                    size="sm"
                    class="text-zinc-500"
                    @click="$dispatch('collapse-all')">
                    Collapse all
                </flux:button>
            </div>

            <!-- Accordion Container -->
            @php

            $completedLessonIds = auth()->user()
            ->completedLessons
            ->pluck('id')
            ->toArray();

            @endphp
            <div class="border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden bg-zinc-50/50 dark:bg-zinc-900/20">
                @foreach ($course->modules as $module)
                <div x-data="{ open: false }" @collapse-all.window="open = false"
                    class="border-b border-zinc-200 dark:border-zinc-800 last:border-b-0">
                    <!-- Module Header -->
                    <button
                        @click="open = !open"
                        class="w-full p-4 flex justify-between items-center bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                        <div class="flex items-center gap-3">
                            <flux:icon.chevron-right
                                variant="micro"
                                class="text-zinc-400 transition-transform duration-300"
                                ::class="open ? 'rotate-90' : ''" />
                            <span class="font-semibold text-zinc-900 dark:text-zinc-100 text-left">
                                {{ $module->title }}
                            </span>
                        </div>
                        <span class="text-xs text-zinc-400">
                            {{ $module->lessons->count() }} lessons
                        </span>
                    </button>

                    <!-- Lessons List -->
                    <div x-show="open" x-collapse class="bg-zinc-50/30 dark:bg-zinc-900/50">
                        @foreach ($module->lessons as $lesson)
                        @php

                        $isCompleted = in_array(
                        $lesson->id,
                        $completedLessonIds
                        );

                        @endphp

                        <div
                            class="p-4 flex items-center gap-4
    hover:bg-zinc-100/50 dark:hover:bg-zinc-800/40
    cursor-pointer group transition">

                            <!-- STATUS ICON -->
                            <div class="
        w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300

        {{ $isCompleted
            ? 'bg-blue-600 border-blue-600'
            : 'border-zinc-300 dark:border-zinc-600 bg-zinc-100 dark:bg-zinc-800'
        }}
    ">

                                @if($isCompleted)

                                <flux:icon.check
                                    variant="mini"
                                    class="w-3 h-3 text-white" />

                                @endif

                            </div>

                            <!-- LESSON TITLE -->
                            <flux:text
                                size="sm"
                                class="
            transition-colors

            {{ $isCompleted
                ? 'text-blue-700 dark:text-blue-500 font-medium'
                : 'group-hover:text-zinc-900 dark:group-hover:text-white'
            }}
        ">

                                {{ $lesson->title }}

                            </flux:text>

                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @php

        $hasCertificate =
        $isCompleted;

        @endphp

        @if($hasCertificate)

        <div class="mt-16">

            <flux:separator class="mb-10" />

            <div class="rounded-3xl
        border border-emerald-200 dark:border-emerald-900
        bg-gradient-to-br
        from-emerald-50 to-white
        dark:from-emerald-950/40 dark:to-zinc-900
        p-8">

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

                    <!-- LEFT -->
                    <div class="flex items-start gap-4">

                        <div class="w-16 h-16 rounded-2xl
                    bg-emerald-500/10
                    flex items-center justify-center">

                            <flux:icon.trophy
                                class="w-8 h-8 text-emerald-500" />

                        </div>

                        <div>

                            <flux:heading
                                size="lg"
                                class="text-zinc-900 dark:text-white">

                                Certificate Earned

                            </flux:heading>

                            <flux:text
                                class="mt-2 text-zinc-600 dark:text-zinc-400 max-w-xl">

                                Congratulations! You have successfully completed
                                this course and earned a certificate of completion.

                            </flux:text>

                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="flex items-center gap-3">

                        <!-- Preview -->
                        <flux:button
                            href="{{ route('certificates.show', $course->id) }}"
                            wire:navigate
                            variant="ghost"
                            icon="eye"
                            class="rounded-2xl">

                            Preview

                        </flux:button>


                    </div>

                </div>

            </div>

        </div>

        @endif
    </div>
</x-app-layout>