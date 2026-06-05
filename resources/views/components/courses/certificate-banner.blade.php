@props(['course'])

<div class="mt-16">

    <flux:separator class="mb-10" />

    <div class="rounded-3xl
        border border-emerald-200 dark:border-emerald-900
        bg-gradient-to-br
        from-emerald-50 to-white
        dark:from-emerald-950/40 dark:to-zinc-900
        p-5 md:p-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

            <!-- LEFT -->
            <div class="flex items-start gap-4">

                <div class="w-24 h-12 md:w-16 md:h-16 rounded-2xl
                    bg-emerald-500/10
                    flex items-center justify-center">

                    <flux:icon.trophy class="w-6 h-6 lg:w-8 lg:h-8 text-emerald-500" />

                </div>

                <div>

                    <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                        Certificate Earned
                    </flux:heading>

                    <flux:text class="mt-2 text-zinc-600 dark:text-zinc-400 max-w-xl">
                        Congratulations! You have successfully completed
                        this course and earned a certificate of completion.
                    </flux:text>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="w-full md:w-auto">

                <flux:button
                    href="{{ route('certificates.show', $course->id) }}"
                    wire:navigate
                    variant="ghost"
                    icon="eye"
                    class="w-full md:w-auto rounded-2xl">

                    Preview

                </flux:button>

            </div>

        </div>

    </div>

</div>