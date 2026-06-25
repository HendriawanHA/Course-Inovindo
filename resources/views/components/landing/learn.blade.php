<section id="values" class="relative overflow-hidden bg-zinc-50 dark:bg-zinc-900 px-6 md:px-12 lg:px-24 py-20">
    <x-landing.dark-bg />
    <div class="relative z-10 max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
        <!-- TEXT -->
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="h-[3px] w-12 rounded-full bg-gradient-to-r from-blue-700 to-emerald-500"></div>
                <span class="text-sm font-medium text-blue-700 dark:text-emerald-400">
                    Kenapa Memilih Kami?
                </span>
            </div>
            <h2 class="text-3xl md:text-5xl font-bold text-zinc-900 dark:text-white leading-tight">
                Pengalaman Belajar
                <span class="bg-gradient-to-r from-blue-700 to-emerald-500 bg-clip-text text-transparent">
                    Premium
                </span>
            </h2>
            <p class="mt-6 text-zinc-600 dark:text-zinc-400 text-lg">
                Belajar menjadi lebih menyenangkan dengan
                sistem modern yang membantu kamu memahami
                materi lebih cepat dan terarah.
            </p>
            <!-- FEATURES -->
            <div class="mt-10 space-y-6">
                <!-- Item -->
                <div class="flex items-start gap-5">
                    <div class="shrink-0 p-3 rounded-2xl bg-gradient-to-tr from-blue-700 to-emerald-500 text-white shadow-lg shadow-blue-700/20">
                        <flux:icon.presentation-chart-bar class="size-7" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg text-zinc-900 dark:text-white">
                            Belajar Lebih Interaktif
                        </h3>
                        <p class=" text-zinc-600 dark:text-zinc-400">
                            Materi disusun secara terstruktur
                            sehingga mudah dipahami dan diikuti.
                        </p>
                    </div>
                </div>
                <!-- Item -->
                <div class="flex items-start gap-5">
                    <div class="shrink-0 p-3 rounded-2xl bg-gradient-to-tr from-blue-700 to-emerald-500 text-white shadow-lg shadow-blue-700/20">
                        <flux:icon.arrow-trending-up class="size-7" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg text-zinc-900 dark:text-white">
                            Pantau Progres Belajar
                        </h3>
                        <p class="text-zinc-600 dark:text-zinc-400">
                            Ketahui perkembangan belajar
                            dan target yang telah dicapai.
                        </p>
                    </div>
                </div>
                <!-- Item -->
                <div class="flex items-start gap-5">
                    <div class="shrink-0 p-3 rounded-2xl bg-gradient-to-tr from-blue-700 to-emerald-500 text-white shadow-lg shadow-blue-700/20">
                        <flux:icon.check-badge class="size-7" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg text-zinc-900 dark:text-white">
                            Sertifikat Resmi
                        </h3>
                        <p class="text-zinc-600 dark:text-zinc-400">
                            Dapatkan sertifikat sebagai bukti
                            pencapaian setelah menyelesaikan kursus.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- IMAGE -->
        <div class="relative">
            <img src="{{ asset('images/illust-experience.png') }}" class="w-full max-w-xl mx-auto drop-shadow-2xl hidden md:block transition-all duration-300 hover:scale-105">
        </div>
    </div>
</section>