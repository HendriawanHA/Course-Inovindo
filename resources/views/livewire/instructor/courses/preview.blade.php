<div x-data="{ videoOpen: false, videoUrl: '', videoTitle: '' }" class="space-y-8">

    {{-- HEADER --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">

        <div class="relative h-72 overflow-hidden bg-zinc-100 dark:bg-zinc-800">
            @if ($course->thumbnail)
                <img src="{{ asset('storage/' . $course->thumbnail) }}" class="h-full w-full object-cover">
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent"></div>

            <div class="absolute bottom-0 left-0 p-8">
                <div class="mb-4 flex items-center gap-3">
                    <span class="rounded-full bg-indigo-500/20 px-3 py-1 text-xs font-semibold text-indigo-300">
                        Instructor Preview
                    </span>

                    @if ($course->is_published)
                        <span class="rounded-full bg-green-500/20 px-3 py-1 text-xs font-semibold text-green-300">
                            Published
                        </span>
                    @else
                        <span class="rounded-full bg-yellow-500/20 px-3 py-1 text-xs font-semibold text-yellow-300">
                            Draft
                        </span>
                    @endif
                </div>

                <h1 class="max-w-3xl text-4xl font-bold text-white">
                    {{ $course->title }}
                </h1>

                <p class="mt-4 max-w-2xl text-zinc-300">
                    {{ $course->description }}
                </p>
            </div>
        </div>

    </div>

    {{-- CURRICULUM --}}
    <section class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                Curriculum
            </h2>

            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                {{ $course->modules->count() }} modules
            </p>
        </div>

        <div class="space-y-4 p-6">
            @forelse ($course->modules as $module)
                <div class="overflow-hidden rounded-lg border border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-950/40">

                    <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">
                            {{ $module->title }}
                        </h3>

                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $module->lessons->count() }} lessons
                        </p>
                    </div>

                    <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($module->lessons as $lesson)
                            <div class="flex items-center gap-4 px-5 py-4">

                                @if ($lesson->youtube_thumbnail_url)
                                    <img src="{{ $lesson->youtube_thumbnail_url }}" alt="{{ $lesson->title }}"
                                        class="h-20 w-32 rounded-xl object-cover">
                                @else
                                    <div
                                        class="flex h-20 w-32 items-center justify-center rounded-xl bg-zinc-100 text-xs text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                        No Video
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <p class="font-medium text-zinc-900 dark:text-white">
                                        {{ $lesson->title }}
                                    </p>

                                    @if ($lesson->video_url)
                                        <p class="mt-1 line-clamp-1 text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $lesson->video_url }}
                                        </p>
                                    @endif
                                </div>

                                @if ($lesson->youtube_embed_url)
                                    <button type="button"
                                        @click="videoUrl = '{{ $lesson->youtube_embed_url }}'; videoTitle = {{ Js::from($lesson->title) }}; videoOpen = true"
                                        class="rounded-xl border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                                        Preview
                                    </button>
                                @endif

                            </div>
                        @empty
                            <div class="px-5 py-6 text-sm text-zinc-500 dark:text-zinc-400">
                                No lessons yet.
                            </div>
                        @endforelse
                    </div>

                </div>
            @empty
                <div class="rounded-lg border border-dashed border-zinc-300 p-10 text-center dark:border-zinc-700">
                    <p class="text-zinc-500 dark:text-zinc-400">
                        No modules yet.
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    <div x-show="videoOpen" x-cloak
         @keydown.escape.window="videoOpen = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-zinc-900/70 backdrop-blur-sm">
        <div @click.outside="videoOpen = false"
             class="w-full max-w-3xl rounded-2xl bg-white p-4 shadow-xl dark:bg-zinc-900">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white" x-text="videoTitle"></h3>
                <button @click="videoOpen = false"
                    class="rounded-lg p-1.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <flux:icon.x-mark class="size-4" />
                </button>
            </div>
            <div class="aspect-video rounded-xl overflow-hidden bg-black">
                <iframe class="w-full h-full" :src="videoUrl" frameborder="0" allowfullscreen allow="autoplay"></iframe>
            </div>
        </div>
    </div>

</div>
