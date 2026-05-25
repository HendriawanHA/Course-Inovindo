<div class="space-y-8">

    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm text-zinc-400">
                Courses <span class="mx-2">›</span> {{ $course->title }} <span class="mx-2">›</span> Edit
            </p>

            <h1 class="mt-2 text-3xl font-bold text-white">
                Edit Course
            </h1>
        </div>

        <a href="{{ route('courses.show', $course->id) }}" target="_blank"
            class="rounded-2xl border border-zinc-700 px-5 py-3 text-sm font-semibold text-zinc-200 hover:bg-zinc-800">
            Preview Course
        </a>
    </div>

  

    {{-- SECTION 1: COURSE DETAILS --}}
    <section class="rounded-3xl border border-zinc-800 bg-zinc-900">
        <div class="border-b border-zinc-800 px-6 py-5">
            <h2 class="font-semibold text-white">Course Details</h2>
            <p class="mt-1 text-sm text-zinc-400">Informasi utama course dan thumbnail.</p>
        </div>

        <div class="grid gap-6 p-6 lg:grid-cols-[1fr_340px]">
            <div class="space-y-5">
                <div>
                    <label class="text-sm font-semibold text-white">Judul Course</label>
                    <input type="text" wire:model.live="title"
                        class="mt-2 w-full rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:ring-indigo-500">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-white">Deskripsi</label>
                    <textarea rows="6" wire:model.live="description"
                        class="mt-2 w-full rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-white">Harga</label>
                        <input type="number" wire:model.live="price"
                            class="mt-2 w-full rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:ring-indigo-500">
                        @error('price')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-end">
                        <label
                            class="flex w-full items-center justify-between rounded-2xl border border-zinc-700 bg-zinc-800 px-5 py-4">
                            <div>
                                <p class="text-sm font-semibold text-white">Publish</p>
                                <p class="mt-1 text-xs text-zinc-400">Tampilkan course ke student.</p>
                            </div>

                            <input type="checkbox" wire:model.live="is_published"
                                class="rounded border-zinc-600 bg-zinc-900 text-indigo-600 focus:ring-indigo-500">
                        </label>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-zinc-800 bg-zinc-950/40 p-5">
                <h3 class="text-sm font-semibold text-white">Thumbnail</h3>

                <div class="mt-4 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-800">
                    @if ($thumbnail)
                        <img src="{{ $thumbnail->temporaryUrl() }}" class="h-56 w-full object-cover">
                    @elseif ($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="h-56 w-full object-cover">
                    @else
                        <div class="flex h-56 items-center justify-center text-sm text-zinc-500">
                            No Thumbnail
                        </div>
                    @endif
                </div>

                <input type="file" wire:model="thumbnail"
                    class="mt-4 block w-full text-sm text-zinc-300 file:mr-4 file:rounded-xl file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-500">

                @error('thumbnail')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    {{-- SECTION 2: CURRICULUM --}}
    <section class="rounded-3xl border border-zinc-800 bg-zinc-900">
        <div class="border-b border-zinc-800 px-6 py-5">
            <h2 class="font-semibold text-white">Curriculum</h2>
            <p class="mt-1 text-sm text-zinc-400">Kelola module dan lesson di dalam course.</p>
        </div>

        <div class="space-y-6 p-6">


            <div class="space-y-5">
                @forelse ($modules as $module)
                    <div class="overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-950/40">
                        <div class="flex items-center justify-between gap-4 border-b border-zinc-800 px-5 py-4">
                            <div>
                                <h3 class="font-semibold text-white">{{ $module->title }}</h3>
                                <p class="mt-1 text-xs text-zinc-500">{{ $module->lessons->count() }} lesson</p>
                            </div>

                            <button type="button" wire:click="deleteModule({{ $module->id }})"
                                wire:confirm="Hapus module ini beserta semua lesson?"
                                class="rounded-xl border border-red-500/30 px-3 py-2 text-xs font-semibold text-red-400 hover:bg-red-500/10">
                                Delete Module
                            </button>
                        </div>

                        <div class="space-y-4 p-5">
                            @forelse ($module->lessons as $lesson)
                                <div class="rounded-2xl border border-zinc-800 bg-zinc-900 px-4 py-4">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-sm font-semibold text-white">{{ $lesson->title }}</p>

                                            <p class="mt-1 text-xs text-zinc-500">
                                                {{ $lesson->video_url ?: 'No video link yet' }}
                                            </p>
                                        </div>

                                        <button type="button" wire:click="deleteLesson({{ $lesson->id }})"
                                            wire:confirm="Hapus lesson ini?"
                                            class="text-sm font-semibold text-red-400 hover:text-red-300">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-zinc-800 p-5 text-center">
                                    <p class="text-sm text-zinc-500">Belum ada lesson di module ini.</p>
                                </div>
                            @endforelse

                            <div class="rounded-2xl border border-zinc-800 bg-zinc-900/70 p-4">
                                <p class="text-sm font-semibold text-white">Tambah Lesson</p>

                                <div class="mt-3 grid gap-3 md:grid-cols-2">
                                    <input type="text" wire:model.defer="lessonTitles.{{ $module->id }}"
                                        placeholder="Judul lesson..."
                                        class="rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white placeholder:text-zinc-500 focus:border-indigo-500 focus:ring-indigo-500">

                                    <input type="url" wire:model.defer="lessonVideoUrls.{{ $module->id }}"
                                        placeholder="Link video YouTube / embed..."
                                        class="rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white placeholder:text-zinc-500 focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                @error('lessonTitles.' . $module->id)
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror

                                <button type="button" wire:click="addLesson({{ $module->id }})"
                                    class="mt-3 rounded-2xl border border-zinc-700 px-5 py-3 text-sm font-semibold text-zinc-200 hover:bg-zinc-800">
                                    Add Lesson
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-zinc-700 p-8 text-center">
                        <h3 class="font-semibold text-white">Belum ada module</h3>
                        <p class="mt-2 text-sm text-zinc-400">Tambahkan module pertama untuk menyusun curriculum course.
                        </p>
                    </div>
                @endforelse

                <div class="rounded-2xl border border-zinc-800 bg-zinc-950/40 p-5">
                    <label class="text-sm font-semibold text-white">Tambah Module</label>

                    <div class="mt-3 flex flex-col gap-3 md:flex-row">
                        <input type="text" wire:model.defer="moduleTitle" placeholder="Contoh: Introduction"
                            class="flex-1 rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white placeholder:text-zinc-500 focus:border-indigo-500 focus:ring-indigo-500">

                        <button type="button" wire:click="addModule"
                            class="rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                            Add Module
                        </button>
                    </div>

                    @error('moduleTitle')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </section>

    <div class="flex items-center gap-3">
        <button wire:click="save"
            class="rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
            Save Changes
        </button>

        <a href="{{ route('instructor.courses.index') }}"
            class="rounded-2xl border border-zinc-700 px-6 py-3 text-sm font-semibold text-zinc-200 transition hover:bg-zinc-800">
            Back to Courses
        </a>
    </div>

</div>
