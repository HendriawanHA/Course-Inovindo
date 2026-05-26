<x-app-layout>

    <flux:main class="min-h-screen bg-zinc-100 dark:bg-zinc-950 p-8">

        <div class="max-w-5xl mx-auto">

            <!-- PAGE HEADER -->
            <div class="mb-8">

                <flux:heading
                    size="xl"
                    class="flex items-center gap-3 text-zinc-900 dark:text-white">

                    <flux:icon.academic-cap
                        variant="solid"
                        class="size-7 text-indigo-500" />

                    Certificate

                </flux:heading>

                <flux:text class="mt-2 text-zinc-500 dark:text-zinc-400">
                    Your course completion certificate.
                </flux:text>

            </div>

            <!-- CERTIFICATE -->
            <div class="relative overflow-hidden
                rounded-[2rem]
                border border-zinc-200 dark:border-zinc-800
                bg-white dark:bg-zinc-900
                shadow-2xl">

                <!-- Background Glow -->
                <div class="absolute -top-32 -left-32
                    w-96 h-96 rounded-full
                    bg-indigo-500/10 blur-3xl">
                </div>

                <div class="absolute -bottom-32 -right-32
                    w-96 h-96 rounded-full
                    bg-blue-500/10 blur-3xl">
                </div>

                <!-- Content -->
                <div class="relative p-16">

                    <!-- Top -->
                    <div class="flex items-center justify-between">

                        <div>

                            <div class="flex items-center gap-3">

                                <div class="w-14 h-14 rounded-2xl
                                    bg-indigo-500/10
                                    flex items-center justify-center">

                                    <flux:icon.trophy
                                        variant="solid"
                                        class="size-7 text-indigo-500" />

                                </div>

                                <div>

                                    <p class="text-xs uppercase tracking-[0.3em]
                                        text-zinc-500 dark:text-zinc-400">

                                        Certificate of Completion

                                    </p>

                                    <h1 class="mt-1 text-2xl font-bold
                                        text-zinc-900 dark:text-white">

                                        Inovindo Course

                                    </h1>

                                </div>

                            </div>

                        </div>

                        <div>

                            <flux:badge
                                color="emerald"
                                size="sm">

                                Completed

                            </flux:badge>

                        </div>

                    </div>

                    <!-- Middle -->
                    <div class="mt-20 text-center">

                        <p class="text-zinc-500 dark:text-zinc-400 text-lg">
                            This certificate is proudly presented to
                        </p>

                        <h2 class="mt-6 text-6xl font-black
                            tracking-tight
                            text-indigo-600">

                            {{ $user->name }}

                        </h2>

                        <div class="w-32 h-1 rounded-full
                            bg-indigo-500 mx-auto mt-8">
                        </div>

                        <p class="mt-10 text-lg leading-relaxed
                            text-zinc-600 dark:text-zinc-300
                            max-w-2xl mx-auto">

                            For successfully completing the course

                            <span class="font-bold text-zinc-900 dark:text-white">
                                "{{ $course->title }}"
                            </span>

                            and fulfilling all learning requirements.

                        </p>

                    </div>

                    <!-- Bottom -->
                    <div class="mt-24 grid grid-cols-2 gap-10">

                        <!-- Completion -->
                        <div class="rounded-3xl
                            border border-zinc-200 dark:border-zinc-800
                            bg-zinc-50 dark:bg-zinc-950/50
                            p-6">

                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                Completion Date
                            </p>

                            <h3 class="mt-2 text-xl font-bold
                                text-zinc-900 dark:text-white">

                                {{ $enrollment->completed_at?->format('d M Y') }}

                            </h3>

                        </div>

                        <!-- Instructor -->
                        <div class="rounded-3xl
                            border border-zinc-200 dark:border-zinc-800
                            bg-zinc-50 dark:bg-zinc-950/50
                            p-6">

                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                Instructor
                            </p>

                            <h3 class="mt-2 text-xl font-bold
                                text-zinc-900 dark:text-white">

                                {{ $course->instructor->name ?? 'Instructor' }}

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ACTION -->
            <div class="mt-8 flex justify-center gap-4">

                <a
                    href="{{ route('courses.show', $course->id) }}"
                    wire:navigate>

                    <flux:button
                        variant="ghost"
                        class="rounded-2xl">

                        Back to Course

                    </flux:button>

                </a>

                <a
                    href="{{ route('certificates.download', $course->id) }}">

                    <flux:button
                        variant="primary"
                        icon="arrow-down-tray"
                        class="rounded-2xl">

                        Download PDF

                    </flux:button>

                </a>

            </div>

        </div>

    </flux:main>

</x-app-layout>