<x-layouts.instructor>
    <div class="space-y-8">

    {{-- HERO --}}
    <section class="overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-900">

        <div class="h-40 bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600"></div>

        <div class="relative px-8 pb-8">

            <div class="-mt-16 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-end">

                    <img
                        src="{{ auth()->user()?->avatar
                            ? asset('storage/' . auth()->user()->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                        class="h-32 w-32 rounded-3xl border-4 border-zinc-900 object-cover shadow-2xl shadow-black/40"
                    >

                    <div class="pb-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <h1 class="text-3xl font-bold text-white">
                                {{ auth()->user()->name }}
                            </h1>

                            <span class="rounded-full bg-indigo-500/20 px-3 py-1 text-xs font-semibold text-indigo-300">
                                Instructor
                            </span>
                        </div>

                        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-zinc-400">
                            Bangun course berkualitas, bantu student berkembang, dan kelola pembelajaran dengan lebih modern.
                        </p>
                    </div>

                </div>

                <div class="flex gap-3">
                    <button
                        class="rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        Edit Profile
                    </button>

                </div>

            </div>

        </div>

    </section>

    {{-- CONTENT --}}
    <div class="grid gap-6 xl:grid-cols-[1fr_340px]">

        {{-- LEFT --}}
        <div class="space-y-6">

            {{-- ABOUT --}}
            <section class="rounded-3xl border border-zinc-800 bg-zinc-900 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white">
                            About
                        </h2>

                        <p class="mt-1 text-sm text-zinc-400">
                            Informasi singkat mengenai instructor.
                        </p>
                    </div>
                </div>

                <div class="mt-6 space-y-5">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Email
                        </p>

                        <p class="mt-2 text-sm text-white">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Expertise
                        </p>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="rounded-full bg-zinc-800 px-3 py-2 text-sm text-zinc-300">
                                Laravel
                            </span>

                            <span class="rounded-full bg-zinc-800 px-3 py-2 text-sm text-zinc-300">
                                Livewire
                            </span>

                            <span class="rounded-full bg-zinc-800 px-3 py-2 text-sm text-zinc-300">
                                Web Development
                            </span>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Bio
                        </p>

                        <p class="mt-3 text-sm leading-relaxed text-zinc-400">
                            Instructor aktif yang berfokus pada pengembangan web modern menggunakan Laravel, Livewire, dan TailwindCSS.
                        </p>
                    </div>

                </div>
            </section>

            {{-- ACTIVITY --}}
            <section class="rounded-3xl border border-zinc-800 bg-zinc-900 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white">
                            Recent Activity
                        </h2>

                        <p class="mt-1 text-sm text-zinc-400">
                            Aktivitas terbaru instructor.
                        </p>
                    </div>
                </div>

                <div class="mt-6 space-y-4">

                    <div class="flex items-start gap-4 rounded-2xl border border-zinc-800 bg-zinc-950/40 p-4">
                        <div class="mt-1 h-3 w-3 rounded-full bg-green-400"></div>

                        <div>
                            <p class="font-medium text-white">
                                Published new course
                            </p>

                            <p class="mt-1 text-sm text-zinc-400">
                                Laravel LMS Masterclass
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 rounded-2xl border border-zinc-800 bg-zinc-950/40 p-4">
                        <div class="mt-1 h-3 w-3 rounded-full bg-indigo-400"></div>

                        <div>
                            <p class="font-medium text-white">
                                Added new module
                            </p>

                            <p class="mt-1 text-sm text-zinc-400">
                                Authentication & Authorization
                            </p>
                        </div>
                    </div>

                </div>
            </section>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            {{-- STATS --}}
            <section class="rounded-3xl border border-zinc-800 bg-zinc-900 p-6">

                <h2 class="text-xl font-bold text-white">
                    Statistics
                </h2>

                <div class="mt-6 grid gap-4">

                    <div class="rounded-2xl bg-zinc-950/50 p-5">
                        <p class="text-sm text-zinc-500">
                            Total Courses
                        </p>

                        <p class="mt-2 text-3xl font-bold text-white">
                            12
                        </p>
                    </div>

                    <div class="rounded-2xl bg-zinc-950/50 p-5">
                        <p class="text-sm text-zinc-500">
                            Total Students
                        </p>

                        <p class="mt-2 text-3xl font-bold text-white">
                            248
                        </p>
                    </div>

                    <div class="rounded-2xl bg-zinc-950/50 p-5">
                        <p class="text-sm text-zinc-500">
                            Completion Rate
                        </p>

                        <p class="mt-2 text-3xl font-bold text-white">
                            84%
                        </p>
                    </div>

                </div>

            </section>

            {{-- SOCIAL --}}
            <section class="rounded-3xl border border-zinc-800 bg-zinc-900 p-6">

                <h2 class="text-xl font-bold text-white">
                    Social Links
                </h2>

                <div class="mt-6 space-y-3">

                    <a href="#"
                        class="flex items-center justify-between rounded-2xl border border-zinc-800 bg-zinc-950/40 px-4 py-4 text-sm text-zinc-300 transition hover:border-indigo-500/30 hover:bg-indigo-500/5">
                        <span>GitHub</span>
                        <span class="text-zinc-500">→</span>
                    </a>

                    <a href="#"
                        class="flex items-center justify-between rounded-2xl border border-zinc-800 bg-zinc-950/40 px-4 py-4 text-sm text-zinc-300 transition hover:border-indigo-500/30 hover:bg-indigo-500/5">
                        <span>LinkedIn</span>
                        <span class="text-zinc-500">→</span>
                    </a>

                </div>

            </section>

        </div>

    </div>

</div>
</x-layouts.instructor>
