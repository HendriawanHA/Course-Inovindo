@props([
'coursesCount','studentsCount','eventsCount'
])
<div class="p-4 mt-2 md:p-6">

    <div class="grid grid-cols-3 gap-3 md:gap-6">

        <x-landing.card-wrapper>
            <flux:card
                class="
                bg-white dark:bg-zinc-900
                border border-zinc-200 dark:border-zinc-800

                text-center

                px-2 py-4
                md:px-6 md:py-6

                transition-all duration-300
                hover:-translate-y-2
                hover:shadow-2xl
                hover:shadow-blue-700/20
                hover:border-emerald-500
                ">

                <div class="text-xl md:text-3xl font-bold text-emerald-500">
                    {{ $coursesCount }}
                </div>

                <div class="text-xs md:text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                    Courses
                </div>

            </flux:card>
        </x-landing.card-wrapper>

        <x-landing.card-wrapper>
            <flux:card
                class="
                bg-white dark:bg-zinc-900
                border border-zinc-200 dark:border-zinc-800

                text-center

                px-2 py-4
                md:px-6 md:py-6

                transition-all duration-300
                hover:-translate-y-2
                hover:shadow-2xl
                hover:shadow-blue-700/20
                hover:border-emerald-500
                ">

                <div class="text-xl md:text-3xl font-bold text-emerald-500">
                    {{ $studentsCount }}
                </div>

                <div class="text-xs md:text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                    Students
                </div>

            </flux:card>
        </x-landing.card-wrapper>

        <x-landing.card-wrapper>
            <flux:card
                class="
                bg-white dark:bg-zinc-900
                border border-zinc-200 dark:border-zinc-800

                text-center

                px-2 py-4
                md:px-6 md:py-6

                transition-all duration-300
                hover:-translate-y-2
                hover:shadow-2xl
                hover:shadow-blue-700/20
                hover:border-emerald-500
                ">

                <div class="text-xl md:text-3xl font-bold text-emerald-500">
                    {{ $eventsCount }}
                </div>

                <div class="text-xs md:text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                    Events
                </div>

            </flux:card>
        </x-landing.card-wrapper>

    </div>

</div>