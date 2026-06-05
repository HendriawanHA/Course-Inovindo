@props(['modules'])

<div class="space-y-6">

    <div class="flex flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <flux:heading size="lg">Content</flux:heading>

            <div class="flex items-center gap-2">
                <flux:text variant="subtle" size="sm">
                    {{ $modules->count() }} Modules
                </flux:text>

                <flux:separator vertical small />

                <flux:text variant="subtle" size="sm">
                    {{ $modules->sum('total_lessons') }} Lessons
                </flux:text>
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

    <!-- ACCORDION -->
    <div class="border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden bg-zinc-50/50 dark:bg-zinc-900/20">

        @foreach ($modules as $module)

        <div x-data="{ open: false }"
            @collapse-all.window="open = false"
            class="border-b border-zinc-200 dark:border-zinc-800 last:border-b-0">

            <!-- MODULE HEADER -->
            <button
                @click="open = !open"
                class="w-full p-4 flex items-start justify-between gap-4 bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">

                <div class="flex items-center gap-3">
                    <flux:icon.chevron-right
                        variant="micro"
                        class="text-zinc-400 transition-transform duration-300"
                        :class="'rotate-90'" : open />

                    <span class="font-semibold text-left break-words text-zinc-900 dark:text-zinc-100">
                        {{ $module->title }}
                    </span>
                </div>

                <span class="text-xs text-zinc-400">
                    {{ $module->total_lessons }} lessons
                </span>

            </button>

            <!-- LESSONS -->
            <div x-show="open" x-collapse class="bg-zinc-50/30 dark:bg-zinc-900/50">

                @foreach ($module->lessons as $lesson)

                <div class="p-4 flex items-start gap-4 hover:bg-zinc-100/50 dark:hover:bg-zinc-800/40 transition">

                    <!-- STATUS -->
                    <div class="
                        w-5 h-5 rounded-full border flex items-center justify-center transition-all duration-300
                        {{ $lesson->is_completed
                            ? 'bg-blue-600 border-blue-600'
                            : 'border-zinc-300 dark:border-zinc-600 bg-zinc-100 dark:bg-zinc-800'
                        }}">

                        @if($lesson->is_completed)
                        <flux:icon.check variant="mini" class="w-3 h-3 text-white" />
                        @endif

                    </div>

                    <!-- TITLE -->
                    <flux:text
                        size="sm"
                        class="break-words {{ $lesson->is_completed
                            ? 'text-blue-700 dark:text-blue-500 font-medium'
                            : 'group-hover:text-zinc-900 dark:group-hover:text-white'
                        }}">

                        {{ $lesson->title }}

                    </flux:text>

                </div>

                @endforeach

            </div>

        </div>

        @endforeach

    </div>

</div>