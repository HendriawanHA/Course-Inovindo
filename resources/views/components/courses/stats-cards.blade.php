<div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4 md:px-8">

    <!-- LEVEL & POINT -->
    <flux:card class="rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-lg">

        <div class="flex items-center gap-4">

            <div class="w-16 h-12 md:w-20 md:h-14 rounded-2xl
                bg-indigo-500/10
                flex items-center justify-center">

                <flux:icon.sparkles
                    variant="solid"
                    class="text-indigo-500 size-6" />

            </div>

            <div class="flex md:flex-col flex-row items-center md:items-start justify-between w-full">

                <p class="text-sm text-zinc-900 dark:text-zinc-400">
                    {{ $user->rank['name'] }}
                </p>

                <h2 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-white">
                    {{ $user->points }} Points
                </h2>

            </div>

        </div>

    </flux:card>

    <!-- MY COURSES -->
    <flux:card class="rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-lg">

        <div class="flex items-center gap-4">

            <div class="w-16 h-12 md:w-20 md:h-14 rounded-2xl
                bg-blue-500/10
                flex items-center justify-center">

                <flux:icon.book-open
                    variant="solid"
                    class="text-blue-500 size-6" />

            </div>

            <div class="flex md:flex-col flex-row items-center md:items-start justify-between w-full">

                <p class="text-sm text-zinc-900 dark:text-zinc-400">
                    My Courses
                </p>

                <h2 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-white">
                    {{ $myCourses }}
                </h2>

            </div>

        </div>

    </flux:card>

    <!-- COMPLETED COURSES -->
    <flux:card class="rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-lg">

        <div class="flex items-center gap-4">

            <div class="w-16 h-12 md:w-20 md:h-14 rounded-2xl
                bg-emerald-500/10
                flex items-center justify-center">

                <flux:icon.trophy
                    variant="solid"
                    class="text-emerald-500 size-6" />

            </div>

            <div class="flex md:flex-col flex-row items-center md:items-start justify-between w-full">

                <p class="text-sm text-zinc-900 dark:text-zinc-400">
                    Certificates
                </p>

                <h2 class="text-xl md:text-2xl font-bold text-zinc-900 dark:text-white">
                    {{ $completedCourses }}
                </h2>

            </div>

        </div>

    </flux:card>

</div>