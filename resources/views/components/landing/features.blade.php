<section id="features"
    class="
    bg-zinc-100
    dark:bg-zinc-900
    py-20
    overflow-hidden relative
">
    <x-landing.dark-bg />
    <div class="flex items-center justify-center gap-2">

        <div class="h-[3px] w-12 rounded-full bg-gradient-to-r from-blue-700 to-emerald-500 "></div>
        <span class="text-sm font-medium text-blue-700 dark:text-emerald-400">
            Jalur Pembelajaran
        </span>
    </div>
    <div class="max-w-7xl mx-auto px-6">
        <!-- Heading -->
        <div class="text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-zinc-900 dark:text-white">
                Perjalanan Belajarmu Jadi Lebih
                <span class="bg-gradient-to-r from-blue-700 to-emerald-500 bg-clip-text text-transparent">
                    Mudah
                </span>
            </h2>
            <p class="mt-4 text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto">
                Mulai belajar hanya dalam beberapa langkah sederhana.
            </p>
        </div>
        <!-- Content -->
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center mt-16 ">
            <!-- Illustration -->
            <div>
                <img src="{{ asset('images/illust-learning.png') }}" alt="Learning Illustration" class="w-full max-w-xl mx-auto transition-all duration-300 hover:scale-105">
            </div>
            <!-- Steps -->
            <div class="space-y-6">
                <!-- Step 1 -->
                <div class="lg:mr-12">
                    <x-landing.card-wrapper>
                        <flux:card class="bg-white dark:bg-zinc-900 flex items-center gap-6 p-6 md:p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
                            <div class="text-4xl font-bold text-blue-700 shrink-0">
                                01
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg text-zinc-900 dark:text-white">
                                    Pilih Kursus
                                </h3>
                                <p class="mt-2 text-zinc-600 dark:text-zinc-400">
                                    Temukan kursus yang sesuai dengan minat dan tujuan belajar kamu.
                                </p>
                            </div>
                        </flux:card>
                    </x-landing.card-wrapper>
                </div>

                <!-- Step 2 -->
                <div class="lg:ml-12">
                    <x-landing.card-wrapper>
                        <flux:card class="bg-white dark:bg-zinc-900 flex items-center gap-6 p-6 md:p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
                            <div>
                                <h3 class="font-semibold text-lg text-zinc-900 dark:text-white">
                                    Belajar di Mana Saja
                                </h3>
                                <p class="mt-2 text-zinc-600 dark:text-zinc-400">
                                    Akses materi pembelajaran melalui desktop, tablet, maupun smartphone.
                                </p>
                            </div>
                            <div class="text-4xl font-bold text-emerald-500 shrink-0">
                                02
                            </div>
                        </flux:card>
                    </x-landing.card-wrapper>
                </div>

                <!-- Step 3 -->
                <div class="lg:mr-12">
                    <x-landing.card-wrapper>
                        <flux:card class="bg-white dark:bg-zinc-900 flex items-center gap-6 p-6 md:p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
                            <div class="text-4xl font-bold text-blue-700 shrink-0">
                                03
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg text-zinc-900 dark:text-white">
                                    Dapatkan Sertifikat
                                </h3>
                                <p class="mt-2 text-zinc-600 dark:text-zinc-400">
                                    Selesaikan kursus dan unduh sertifikat resmi sebagai bukti pencapaian.
                                </p>
                            </div>
                        </flux:card>
                    </x-landing.card-wrapper>
                </div>
            </div>
        </div>
    </div>
</section>