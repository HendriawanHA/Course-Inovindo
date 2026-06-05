<x-app-layout>

    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto+Mono:wght@100..700&family=Source+Serif+4:wght@200..900&display=swap"
            rel="stylesheet">
    </head>
    <flux:main class="bg-zinc-100 dark:bg-zinc-900 p-4 md:p-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
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

                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <a
                        href="{{ route('courses.show', $course->id) }}"
                        class="w-full sm:w-auto"
                        wire:navigate>
                        <flux:button
                            variant="primary"
                            class="w-full sm:w-auto rounded-2xl !border-2 border-emerald-500/60 hover:bg-emerald-500 hover:!text-white">
                            Back
                        </flux:button>
                    </a>

                    <a
                        href="{{ route('certificates.download', $course->id) }}"
                        class="w-full sm:w-auto hidden md:block">
                        <flux:button
                            icon="arrow-down-tray"
                            class="w-full sm:w-auto hidden md:block !text-white !bg-blue-700 hover:!bg-blue-600 font-medium shadow-lg shadow-blue-600/20 rounded-xl transition-all duration-200">
                            Download PDF
                        </flux:button>
                    </a>
                </div>
            </div>

            <!-- CERTIFICATE -->
            <div class="relative aspect-[2000/1414]" style="font-family: 'Source Serif 4', serif;">
                <img
                    src="{{ asset('images/rev.png') }}"
                    class="w-full h-full object-contain">

                <!-- CERTIFICATE ID -->
                <div class="absolute top-[9.6%] left-[17.5%]">
                    <p class="text-[5px] sm:text-[10px] md:text-[12px] font-medium text-zinc-800">
                        CERT-{{ $user->id }}-{{ $course->id }}
                    </p>
                </div>

                <!-- USER NAME -->
                <div
                    class="absolute
           top-[45%]
           left-1/2 -translate-x-1/2
           w-[70%] text-center">

                    <h1
                        class="
        text-[14px]
        sm:text-[20px]
        md:text-[26px]
        lg:text-[34px]
        font-bold
        text-zinc-900
        leading-none
        break-words
    ">
                        {{ strtoupper($user->name) }}
                    </h1>

                </div>

                <!-- COURSE -->
                <div
                    class="absolute
           top-[62%]
           left-1/2 -translate-x-1/2
           w-[70%] text-center">

                    <h2
                        class="
        text-[10px]
        sm:text-[13px]
        md:text-[18px]
        lg:text-[22px]
        font-semibold
        text-zinc-800
        leading-tight
        break-words
    ">
                        {{ $course->title }}
                    </h2>

                </div>

                <!-- DATE -->
                <div
                    class="absolute
           top-[75%]
           left-1/2 -translate-x-1/2">

                    <p
                        class="
        text-[8px]
        sm:text-[10px]
        md:text-[12px]
        lg:text-[14px]
        text-zinc-800
        whitespace-nowrap
    ">
                        {{ $enrollment->completed_at?->format('d F Y') }}
                    </p>

                </div>
            </div>
        </div>
        <a
            href="{{ route('certificates.download', $course->id) }}"
            class="w-full sm:w-auto">
            <flux:button
                icon="arrow-down-tray"
                class="w-full sm:w-auto mt-6 lg:hidden !text-white !bg-blue-700 hover:!bg-blue-600 font-medium shadow-lg shadow-blue-600/20 rounded-xl transition-all duration-200">
                Download PDF
            </flux:button>
        </a>
        </div>
    </flux:main>
</x-app-layout>