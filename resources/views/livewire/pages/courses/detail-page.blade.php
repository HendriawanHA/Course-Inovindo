<x-app-layout>
    <flux:navbar class="flex items-center gap-2 text-zinc-500 dark:text-zinc-400 px-6">
        <flux:navbar.item href="{{ route('courses.index') }}" wire:navigate>
            <flux:icon.arrow-uturn-left variant="micro" />
        </flux:navbar.item>
        <flux:heading size="lg">
            {{ $course->title }}
        </flux:heading>
    </flux:navbar>

    <flux:separator />

    <div class="max-w-4xl mx-auto mt-6 py-6 px-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-12">
            <flux:heading size="xl" class="text-3xl md:text-4xl">Welcome, {{ auth()->user()->name }}.</flux:heading>

            @php $firstLesson = $course->firstLesson(); @endphp

            @if ($firstLesson)
            <flux:button href="{{ route('courses.video', ['course' => $course->id, 'lesson' => $firstLesson->id]) }}" wire:navigate variant="primary" class="!rounded-full hover:!text-white !border-2 border-blue-700/60 hover:bg-blue-700">
                Start
            </flux:button>
            @endif
        </div>

        <flux:heading size="lg" class="mb-4">Progress</flux:heading>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8 rounded-2xl mb-10 shadow-sm dark:shadow-none">
            <div class="flex justify-between items-end mb-4">
                <flux:text class="text-sm">Completed 0 of 174 lessons</flux:text>
                <span class="font-bold text-zinc-900 dark:text-white">0%</span>
            </div>
            <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-2.5 rounded-full overflow-hidden">
                <div class="bg-indigo-500 h-full w-[2%] shadow-[0_0_10px_rgba(99,102,241,0.3)]"></div>
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
                        <div class="p-4 flex items-center gap-4 hover:bg-zinc-100/50 dark:hover:bg-zinc-800/40 cursor-pointer group transition">
                            <!-- Indicator Dot -->
                            <div class="w-2 h-2 rounded-full border border-zinc-300 dark:border-zinc-600 bg-zinc-100 dark:bg-zinc-800 group-hover:border-indigo-500 transition-colors"></div>

                            <flux:text size="sm" class="group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">
                                {{ $lesson->title }}
                            </flux:text>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>