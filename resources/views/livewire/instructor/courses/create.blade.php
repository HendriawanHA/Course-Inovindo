<div class="space-y-8">

    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Courses
                <span class="mx-2">›</span>
                Create
            </p>

            <h1 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">
                Create New Course
            </h1>

            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                Buat course baru, upload thumbnail, atur harga, dan status publish.
            </p>
        </div>

        <a href="{{ route('instructor.courses.index') }}"
            class="rounded-2xl border border-zinc-300 px-5 py-3 text-sm font-semibold text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
            Back to Courses
        </a>
    </div>


    <div class="grid gap-6 xl:grid-cols-[1fr_360px]">

        <div class="space-y-6 rounded-3xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">

            <div class="flex items-center justify-between border-b border-zinc-200 pb-5 dark:border-zinc-800">
                <div>
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">
                        Course Details
                    </h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        Informasi dasar yang akan dilihat student.
                    </p>
                </div>

                <span class="rounded-full bg-yellow-500/10 px-3 py-1 text-xs font-semibold text-yellow-300">
                    Draft
                </span>
            </div>

            <div>
                <label class="text-sm font-semibold text-white">
                    <span class="text-zinc-900 dark:text-white">Course Title</span> <span class="text-red-400">*</span>
                </label>

                <input
                    type="text"
                    wire:model.live="title"
                    placeholder="Contoh: Laravel Dasar untuk Pemula"
                    class="mt-2 w-full rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder:text-zinc-500"
                >

                @error('title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-white">
                    <span class="text-zinc-900 dark:text-white">Description</span>
                </label>

                <textarea
                    rows="8"
                    wire:model.live="description"
                    placeholder="Jelaskan isi course, target peserta, dan hasil belajar yang akan didapat."
                    class="mt-2 w-full rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder:text-zinc-500"
                ></textarea>

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
                    <label class="text-sm font-semibold text-white">
                        <span class="text-zinc-900 dark:text-white">Price</span> <span class="text-red-400">*</span>
                    </label>

                    <div class="mt-2 flex overflow-hidden rounded-2xl border border-zinc-300 bg-white focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800">
                        <span class="flex items-center border-r border-zinc-300 px-4 text-sm font-semibold text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                            Rp
                        </span>

                        <input
                            type="text"
                            inputmode="numeric"
                            x-model="display"
                            @input="format($event.target.value)"
                            placeholder="0"
                            class="w-full border-0 bg-transparent px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:ring-0 dark:text-white dark:placeholder:text-zinc-500"
                        >
                    </div>

                    @error('price')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-end">
                    <div class="flex w-full items-start gap-3 rounded-2xl border border-zinc-300 bg-zinc-50 px-5 py-4 dark:border-zinc-700 dark:bg-zinc-800">
                        <div class="mt-0.5 flex size-9 shrink-0 items-center justify-center rounded-xl bg-amber-500/10 text-amber-300">
                            <flux:icon.lock-closed class="size-4" />
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                                Draft First
                            </p>
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                Course baru disimpan sebagai draft. Publish dapat dilakukan setelah curriculum memiliki minimal 1 lesson.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="space-y-6">

            <div class="rounded-3xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">
                    Thumbnail
                </h2>

                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    Upload gambar cover course.
                </p>

                <label for="course-thumbnail-create"
                    class="group relative mt-4 block cursor-pointer overflow-hidden rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 transition hover:border-indigo-500/70 hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:bg-zinc-800/80">
                    <div class="aspect-video w-full">
                        @if ($thumbnail)
                            <img src="{{ $thumbnail->temporaryUrl() }}" class="h-full w-full object-cover">
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                <span class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                                    Change thumbnail
                                </span>
                            </div>
                        @else
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-zinc-50 to-zinc-100 p-6 text-center dark:from-zinc-800 dark:to-zinc-950">
                                <div>
                                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-500/10 text-indigo-400 transition group-hover:scale-105 group-hover:bg-indigo-500/20">
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

                    <input id="course-thumbnail-create" type="file" wire:model="thumbnail" accept="image/png,image/jpeg,image/webp" class="sr-only">
                </label>

                @error('thumbnail')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror

            </div>

            <div class="rounded-3xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">
                    Course Summary
                </h2>

                <div class="mt-4 space-y-3">
                    <div class="rounded-2xl bg-zinc-50 p-4 dark:bg-zinc-800">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Title</p>
                        <p class="mt-1 text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $title ?: 'Belum diisi' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-zinc-50 p-4 dark:bg-zinc-800">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Price</p>
                        <p class="mt-1 text-sm font-semibold text-zinc-900 dark:text-white">
                            Rp {{ number_format((float) $price, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-zinc-50 p-4 dark:bg-zinc-800">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Status</p>
                        <p class="mt-1 text-sm font-semibold text-yellow-300">
                            Draft
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900">
                <button
                    wire:click="save"
                    wire:loading.attr="disabled"
                    class="w-full rounded-2xl bg-indigo-600 px-5 py-4 text-sm font-semibold text-white transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span wire:loading.remove wire:target="save">
                        Create Course
                    </span>

                    <span wire:loading wire:target="save">
                        Saving...
                    </span>
                </button>

                <a
                    href="{{ route('instructor.courses.index') }}"
                    class="mt-3 flex w-full items-center justify-center rounded-2xl border border-zinc-300 px-5 py-4 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800"
                >
                    Cancel
                </a>
            </div>

        </div>

    </div>

</div>
