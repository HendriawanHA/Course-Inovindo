<section class="bg-white dark:bg-zinc-900 relative overflow-hidden ">
    <x-landing.dark-bg />
    <div class="max-w-7xl mx-auto px-6 py-14 relative z-10">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-12 items-center">
            <div>
                <h1 class="mt-6 text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-zinc-900 dark:text-white">
                    Kuasai Skill Baru
                    <span class="text-blue-700">
                        Kapan Saja,
                        <span class="text-emerald-500">
                            Di Mana Saja
                        </span>
                    </span>
                </h1>
                <p class="mt-6 text-base md:text-lg text-zinc-600 dark:text-zinc-400">
                    Tingkatkan kemampuan teknologi,
                    bisnis dan profesional melalui
                    kursus online berkualitas.
                </p>
                <x-landing.stats :courses-count="$coursesCount" :students-count="$studentsCount" :events-count="$eventsCount" class="flex justify-between" />
            </div>
            <div class="order-first lg:order-last">
                <img
                    src="{{ asset('images/illust-learning2.png') }}"
                    class="w-full max-w-md lg:max-w-none mx-auto transition-all duration-300 hover:scale-105">
            </div>
        </div>
    </div>
</section>