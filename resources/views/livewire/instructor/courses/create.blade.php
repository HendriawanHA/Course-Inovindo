<div class="space-y-8">

    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm text-zinc-400">
                Courses
                <span class="mx-2">›</span>
                Create
            </p>

            <h1 class="mt-2 text-3xl font-bold text-white">
                Create New Course
            </h1>

            <p class="mt-2 text-sm text-zinc-400">
                Buat course baru, upload thumbnail, atur harga, dan status publish.
            </p>
        </div>

        <a href="{{ route('instructor.courses.index') }}"
            class="rounded-2xl border border-zinc-700 px-5 py-3 text-sm font-semibold text-zinc-200 hover:bg-zinc-800">
            Back to Courses
        </a>
    </div>


    <div class="grid gap-6 xl:grid-cols-[1fr_360px]">

        <div class="space-y-6 rounded-3xl border border-zinc-800 bg-zinc-900 p-6">

            <div class="flex items-center justify-between border-b border-zinc-800 pb-5">
                <div>
                    <h2 class="text-lg font-bold text-white">
                        Course Details
                    </h2>
                    <p class="mt-1 text-sm text-zinc-400">
                        Informasi dasar yang akan dilihat student.
                    </p>
                </div>

                <span class="rounded-full bg-yellow-500/10 px-3 py-1 text-xs font-semibold text-yellow-300">
                    Draft
                </span>
            </div>

            <div>
                <label class="text-sm font-semibold text-white">
                    Course Title <span class="text-red-400">*</span>
                </label>

                <input
                    type="text"
                    wire:model.live="title"
                    placeholder="Contoh: Laravel Dasar untuk Pemula"
                    class="mt-2 w-full rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white placeholder:text-zinc-500 focus:border-indigo-500 focus:ring-indigo-500"
                >

                @error('title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-white">
                    Description
                </label>

                <textarea
                    rows="8"
                    wire:model.live="description"
                    placeholder="Jelaskan isi course, target peserta, dan hasil belajar yang akan didapat."
                    class="mt-2 w-full rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white placeholder:text-zinc-500 focus:border-indigo-500 focus:ring-indigo-500"
                ></textarea>

                @error('description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 md:grid-cols-2">

                <div>
                    <label class="text-sm font-semibold text-white">
                        Price <span class="text-red-400">*</span>
                    </label>

                    <div class="mt-2 flex overflow-hidden rounded-2xl border border-zinc-700 bg-zinc-800 focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                        <span class="flex items-center border-r border-zinc-700 px-4 text-sm font-semibold text-zinc-400">
                            Rp
                        </span>

                        <input
                            type="number"
                            wire:model.live="price"
                            min="0"
                            placeholder="0"
                            class="w-full border-0 bg-transparent px-4 py-3 text-sm text-white placeholder:text-zinc-500 focus:ring-0"
                        >
                    </div>

                    @error('price')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-end">
                    <label class="flex w-full items-center justify-between gap-3 rounded-2xl border border-zinc-700 bg-zinc-800 px-5 py-4">
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Publish Course
                            </p>
                            <p class="mt-1 text-xs text-zinc-400">
                                Aktifkan jika course sudah siap.
                            </p>
                        </div>

                        <input
                            type="checkbox"
                            wire:model.live="is_published"
                            class="rounded border-zinc-600 bg-zinc-900 text-indigo-600 focus:ring-indigo-500"
                        >
                    </label>
                </div>

            </div>

        </div>

        <div class="space-y-6">

            <div class="rounded-3xl border border-zinc-800 bg-zinc-900 p-5">
                <h2 class="text-lg font-bold text-white">
                    Thumbnail
                </h2>

                <p class="mt-1 text-sm text-zinc-400">
                    Upload gambar cover course.
                </p>

                <div class="mt-4 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-800">
                    @if ($thumbnail)
                        <img
                            src="{{ $thumbnail->temporaryUrl() }}"
                            class="h-56 w-full object-cover"
                        >
                    @else
                        <div class="flex h-56 items-center justify-center bg-gradient-to-br from-zinc-800 to-zinc-950 text-center">
                            <div>
                                <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-500/10 text-indigo-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2.5M16 7l-4-4m0 0L8 7m4-4v13" />
                                    </svg>
                                </div>

                                <p class="text-sm font-medium text-zinc-400">
                                    Preview thumbnail
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <input
                    type="file"
                    wire:model="thumbnail"
                    accept="image/*"
                    class="mt-4 block w-full text-sm text-zinc-300
                    file:mr-4 file:rounded-xl file:border-0 file:bg-indigo-600
                    file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white
                    hover:file:bg-indigo-500"
                >

                @error('thumbnail')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror

                <div wire:loading wire:target="thumbnail" class="mt-2 text-sm text-indigo-400">
                    Uploading thumbnail...
                </div>
            </div>

            <div class="rounded-3xl border border-zinc-800 bg-zinc-900 p-5">
                <h2 class="text-lg font-bold text-white">
                    Course Summary
                </h2>

                <div class="mt-4 space-y-3">
                    <div class="rounded-2xl bg-zinc-800 p-4">
                        <p class="text-xs text-zinc-500">Title</p>
                        <p class="mt-1 text-sm font-semibold text-white">
                            {{ $title ?: 'Belum diisi' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-zinc-800 p-4">
                        <p class="text-xs text-zinc-500">Price</p>
                        <p class="mt-1 text-sm font-semibold text-white">
                            Rp {{ number_format((float) $price, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-zinc-800 p-4">
                        <p class="text-xs text-zinc-500">Status</p>
                        <p class="mt-1 text-sm font-semibold {{ $is_published ? 'text-green-300' : 'text-yellow-300' }}">
                            {{ $is_published ? 'Published' : 'Draft' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-zinc-800 bg-zinc-900 p-5">
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
                    class="mt-3 flex w-full items-center justify-center rounded-2xl border border-zinc-700 px-5 py-4 text-sm font-semibold text-zinc-200 transition hover:bg-zinc-800"
                >
                    Cancel
                </a>
            </div>

        </div>

    </div>

</div>
