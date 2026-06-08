<div class="space-y-8">

    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Courses <span class="mx-2">›</span> {{ $course->title }} <span class="mx-2">›</span> Edit
            </p>

            <h1 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                Edit Course
            </h1>
        </div>

        <a href="{{ route('courses.show', $course->id) }}" target="_blank"
            class="rounded-lg border border-zinc-300 px-5 py-3 text-sm font-semibold text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
            Preview Course
        </a>
    </div>

  

    {{-- SECTION 1: COURSE DETAILS --}}
    <section class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
            <h2 class="font-semibold text-zinc-900 dark:text-white">Course Details</h2>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Informasi utama course dan thumbnail.</p>
        </div>

        <div class="grid gap-6 p-6 lg:grid-cols-[1fr_340px]">
            <div class="space-y-5">
                <div>
                    <label class="text-sm font-semibold text-zinc-900 dark:text-white">Judul Course</label>
                    <input type="text" wire:model.live="title"
                        class="mt-2 w-full rounded-lg border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-zinc-900 dark:text-white">Deskripsi</label>
                    <textarea rows="6" wire:model.live="description"
                        class="mt-2 w-full rounded-lg border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"></textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div x-data="{
                        display: @js(number_format((float) $price, 0, ',', '.')),
                        format(value) {
                            const numeric = value.replace(/\D/g, '');
                            this.display = numeric ? new Intl.NumberFormat('id-ID').format(numeric) : '0';
                            $wire.set('price', numeric || 0);
                        },
                    }">
                        <label class="text-sm font-semibold text-zinc-900 dark:text-white">Harga</label>
                        <div class="mt-2 flex overflow-hidden rounded-lg border border-zinc-300 bg-white focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800">
                            <span class="flex items-center border-r border-zinc-300 px-4 text-sm font-semibold text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">Rp</span>
                            <input type="text" inputmode="numeric" x-model="display" @input="format($event.target.value)"
                                placeholder="0"
                                class="w-full border-0 bg-transparent px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:ring-0 dark:text-white dark:placeholder:text-zinc-500">
                        </div>
                        <input type="hidden" wire:model="price">

                        @error('price')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-end">
                        <label
                            class="flex w-full cursor-pointer items-center justify-between gap-4 rounded-lg border border-zinc-300 bg-zinc-50 px-5 py-4 transition hover:border-indigo-500/50 dark:border-zinc-700 dark:bg-zinc-800">
                            <div>
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">Publish</p>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $is_published ? 'Course tampil ke student.' : 'Course masih draft.' }}
                                </p>
                            </div>

                            <input type="checkbox" wire:model.live="is_published" class="peer sr-only">

                            <span class="relative h-7 w-12 shrink-0 rounded-full bg-zinc-700 transition peer-checked:bg-indigo-600 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-indigo-500">
                                <span class="absolute left-1 top-1 size-5 rounded-full bg-white shadow transition {{ $is_published ? 'translate-x-5' : '' }}"></span>
                            </span>
                        </label>
                    </div>
                </div>

                @error('is_published')
                    <p class="text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-5 dark:border-zinc-800 dark:bg-zinc-950/40">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Thumbnail</h3>

                <label for="course-thumbnail-edit"
                    class="group relative mt-4 block cursor-pointer overflow-hidden rounded-lg border border-dashed border-zinc-300 bg-white transition hover:border-indigo-500/70 hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:bg-zinc-800/80">
                    <div class="aspect-video w-full">
                        @if ($thumbnail)
                            <img src="{{ $thumbnail->temporaryUrl() }}" class="h-full w-full object-cover">
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                <span class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                                    New thumbnail selected
                                </span>
                            </div>
                        @elseif ($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="h-full w-full object-cover">
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                <span class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                                    Change thumbnail
                                </span>
                            </div>
                        @else
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-zinc-50 to-zinc-100 p-6 text-center dark:from-zinc-800 dark:to-zinc-950">
                                <div>
                                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400 transition group-hover:scale-105 group-hover:bg-indigo-500/20">
                                        <flux:icon.arrow-up-tray class="size-7" />
                                    </div>
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">Drop thumbnail here or click to upload</p>
                                    <p class="mt-2 text-xs leading-relaxed text-zinc-500 dark:text-zinc-400">JPG, PNG, or WebP. Max 2MB. Recommended 1280x720.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div wire:loading.flex wire:target="thumbnail"
                        class="absolute inset-0 items-center justify-center bg-zinc-950/70 text-sm font-semibold text-white backdrop-blur-sm">
                        Uploading thumbnail...
                    </div>

                    <input id="course-thumbnail-edit" type="file" wire:model="thumbnail" accept="image/png,image/jpeg,image/webp" class="sr-only">
                </label>

                @error('thumbnail')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    {{-- SECTION 2: CURRICULUM --}}
    <section class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
            <h2 class="font-semibold text-zinc-900 dark:text-white">Curriculum</h2>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Kelola module dan lesson di dalam course.</p>
        </div>

        <div class="space-y-6 p-6">


            <div class="space-y-5">
                @forelse ($modules as $module)
                    <div class="overflow-hidden rounded-lg border border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-950/40">
                        <div class="flex items-center justify-between gap-4 border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                            <div>
                                <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $module->title }}</h3>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $module->lessons->count() }} lesson</p>
                            </div>

                            <button type="button" wire:click="deleteModule({{ $module->id }})"
                                wire:confirm="Hapus module ini beserta semua lesson?"
                                class="rounded-xl border border-red-500/30 px-3 py-2 text-xs font-semibold text-red-400 hover:bg-red-500/10">
                                Delete Module
                            </button>
                        </div>

                        <div class="space-y-4 p-5">
                            @forelse ($module->lessons as $lesson)
                                <div class="rounded-lg border border-zinc-200 bg-white px-4 py-4 dark:border-zinc-800 dark:bg-zinc-900">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $lesson->title }}</p>

                                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
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
                                <div class="rounded-lg border border-dashed border-zinc-300 p-5 text-center dark:border-zinc-800">
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Belum ada lesson di module ini.</p>
                                </div>
                            @endforelse

                            <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900/70">
                                @if (! ($showLessonForms[$module->id] ?? false))
                                    <button type="button" wire:click="startAddingLesson({{ $module->id }})"
                                        class="flex w-full items-center justify-center gap-2 rounded-lg border border-dashed border-zinc-300 px-5 py-4 text-sm font-semibold text-zinc-700 transition hover:border-indigo-500/60 hover:bg-indigo-500/10 hover:text-indigo-600 dark:border-zinc-700 dark:text-zinc-200 dark:hover:text-white">
                                        <flux:icon.plus class="size-4" />
                                        Add Lesson
                                    </button>
                                @else
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">Tambah Lesson</p>

                                    <div class="mt-3 grid gap-3 md:grid-cols-2">
                                        <input type="text" wire:model.defer="lessonTitles.{{ $module->id }}"
                                            placeholder="Judul lesson..."
                                            class="rounded-lg border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder:text-zinc-500"
                                            autofocus>

                                        <input type="url" wire:model.defer="lessonVideoUrls.{{ $module->id }}"
                                            placeholder="Link video YouTube / embed..."
                                            class="rounded-lg border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder:text-zinc-500">
                                    </div>

                                    @error('lessonTitles.' . $module->id)
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror

                                    <div class="mt-3 flex flex-col gap-3 sm:flex-row">
                                        <button type="button" wire:click="addLesson({{ $module->id }})"
                                            class="rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                                            Save
                                        </button>

                                        <button type="button" wire:click="cancelAddingLesson({{ $module->id }})"
                                            class="rounded-lg border border-zinc-300 px-5 py-3 text-sm font-semibold text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                                            Cancel
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-lg border border-dashed border-zinc-300 p-8 text-center dark:border-zinc-700">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">Belum ada module</h3>
                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Tambahkan module pertama untuk menyusun curriculum course.
                        </p>
                    </div>
                @endforelse

                <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-5 dark:border-zinc-800 dark:bg-zinc-950/40">
                    @if (! $showModuleForm)
                        <button type="button" wire:click="startAddingModule"
                            class="flex w-full items-center justify-center gap-2 rounded-lg border border-dashed border-zinc-300 px-5 py-4 text-sm font-semibold text-zinc-700 transition hover:border-indigo-500/60 hover:bg-indigo-500/10 hover:text-indigo-600 dark:border-zinc-700 dark:text-zinc-200 dark:hover:text-white">
                            <flux:icon.plus class="size-4" />
                            Add Module
                        </button>
                    @else
                        <label class="text-sm font-semibold text-zinc-900 dark:text-white">Tambah Module</label>

                        <div class="mt-3 flex flex-col gap-3 md:flex-row">
                            <input type="text" wire:model.defer="moduleTitle" placeholder="Contoh: Introduction"
                                class="flex-1 rounded-lg border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder:text-zinc-500"
                                autofocus>

                            <button type="button" wire:click="addModule"
                                class="rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                                Save
                            </button>

                            <button type="button" wire:click="cancelAddingModule"
                                class="rounded-lg border border-zinc-300 px-5 py-3 text-sm font-semibold text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                                Cancel
                            </button>
                        </div>
                    @endif

                    @error('moduleTitle')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </section>

    <div class="flex items-center gap-3">
        <button wire:click="save"
            class="rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
            Save Changes
        </button>

        <a href="{{ route('instructor.courses.index') }}"
            class="rounded-lg border border-zinc-300 px-6 py-3 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
            Back to Courses
        </a>
    </div>

</div>
