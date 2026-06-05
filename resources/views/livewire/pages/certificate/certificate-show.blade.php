<x-app-layout>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto+Mono:wght@100..700&family=Source+Serif+4:wght@200..900&display=swap"
            rel="stylesheet">
    </head>
    <flux:main class="bg-zinc-100 dark:bg-zinc-900 p-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <flux:heading
                        size="xl"
                        class="flex items-center gap-3 text-zinc-900 dark:text-white">
                        <flux:icon.academic-cap
                            variant="solid"
                            class="size-7 text-blue-700" />
                        Certificate Preview
                    </flux:heading>

                    <flux:text class="mt-2 text-zinc-500 dark:text-zinc-400">
                        Preview before downloading your certificate.
                    </flux:text>
                </div>

                <div class="flex gap-3">
                    <a
                        href="{{ route('courses.show', $course->id) }}"
                        wire:navigate>
                        <flux:button
                            variant="primary"
                            class="rounded-2xl !border-2 border-emerald-500/60 hover:bg-emerald-500 hover:!text-white">
                            Back
                        </flux:button>
                    </a>

                    <a
                        href="{{ route('certificates.download', $course->id) }}">
                        <flux:button
                            icon="arrow-down-tray"
                            class="!text-white !bg-blue-700 hover:!bg-blue-600 font-medium shadow-lg shadow-blue-600/20 rounded-xl transition-all duration-200">
                            Download PDF
                        </flux:button>
                    </a>
                </div>
            </div>

            <!-- CERTIFICATE -->
            <div
                class="bg-white rounded-[2rem]
                       shadow-2xl overflow-hidden"
                style="font-family: 'Source Serif 4', serif;">
                <div class="relative aspect-[1123/794]">
                    <img
                        src="{{ asset('images/rev.png') }}"
                        class="w-full h-full object-contain">

                    <div
                        class="absolute top-[9.5%] left-[17.5%]">
                        <p
                            class="text-[clamp(8px,1vw,12px)]
                                   text-zinc-800 font-medium">

                            CERT-{{ $user->id }}-{{ $course->id }}
                        </p>
                    </div>

                    <div
                        class="absolute top-[45%]
                               left-1/2 -translate-x-1/2">
                        <h1
                            class="text-[clamp(18px,4vw,28px)]
                                   font-bold
                                   text-zinc-900
                                   whitespace-nowrap">
                            {{ strtoupper($user->name) }}
                        </h1>
                    </div>

                    <div
                        class="absolute top-[63%]
                               left-1/2 -translate-x-1/2">
                        <h2
                            class="text-[clamp(12px,2vw,18px)]
                                   font-semibold
                                   text-zinc-800
                                   whitespace-nowrap">
                            {{ $course->title }}
                        </h2>
                    </div>

                    <div
                        class="absolute top-[74%]
                               left-1/2 -translate-x-1/2">
                        <p
                            class="text-[clamp(10px,1.4vw,12px)]
                                   text-zinc-800">
                            {{ $enrollment->completed_at?->format('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </flux:main>
</x-app-layout>