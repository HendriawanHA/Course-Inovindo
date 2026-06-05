<div
    x-cloak
    x-show="openPointsModal"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div
        @click="openPointsModal = false"
        class="absolute inset-0 bg-black/60 backdrop-blur-sm">
    </div>

    <div
        @click.stop
        class="relative w-full max-w-xl overflow-hidden rounded-3xl
               bg-white dark:bg-zinc-900
               border border-zinc-200 dark:border-zinc-800
               shadow-2xl">

        <div
            class="
                   px-6 py-8 text-zinc-700">
            <div class="flex flex-row sm:items-center gap-4">
                <div class="size-14 rounded-2xl bg-gradient-to-tr from-blue-700 to-emerald-500
                            flex items-center justify-center">
                    <flux:icon.sparkles
                        variant="solid"
                        class="size-7 text-white" />
                </div>
                <div>
                    <h2 class="dark:text-white text-2xl font-bold">
                        Earn Points
                    </h2>
                    <p class="dark:text-blue-100 text-sm mt-1">
                        Complete learning activities and collect point.
                    </p>
                </div>
            </div>
        </div>

        <flux:separator />

        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-4">
                <div
                    class="rounded-2xl border border-emerald-500/20
                           bg-emerald-500/5 p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <flux:icon.eye
                            variant="micro"
                            class="text-emerald-500" />
                        <h3 class="font-semibold text-emerald-600">
                            Free Course
                        </h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span>Complete Lesson</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                +1 XP
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Complete Module</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                +5 XP
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Complete Course</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                +20 XP
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-amber-500/20
                           bg-amber-500/5 p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <flux:icon.sparkles
                            variant="micro"
                            class="text-amber-500" />
                        <h3 class="font-semibold text-amber-500">
                            Premium Course
                        </h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span>Complete Lesson</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                +3 XP
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Complete Module</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                +15 XP
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Complete Course</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                +50 XP
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="mt-5 rounded-2xl
                       bg-blue-500/10
                       border border-blue-500/20
                       p-4">
                <div class="flex gap-3">
                    <flux:icon.information-circle
                        class="size-5 text-blue-600 shrink-0" />
                    <p class="text-sm text-zinc-600 dark:text-zinc-300">
                        Premium courses reward significantly more XP.
                        Completing an entire course grants the biggest bonus.
                    </p>
                </div>
            </div>

            <flux:button
                @click="openPointsModal = false"
                class="w-full mt-6 rounded-xl !text-white !bg-blue-700 hover:!bg-blue-600 font-medium shadow-lg shadow-blue-600/20 transition-all duration-200">
                Got it
            </flux:button>
        </div>
    </div>
</div>