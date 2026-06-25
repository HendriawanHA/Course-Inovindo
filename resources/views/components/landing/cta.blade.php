<section class="relative overflow-hidden bg-zinc-100 dark:bg-zinc-900">
    <x-landing.dark-bg />
    <div class="relative max-w-5xl mx-auto px-6 py-24 md:py-32 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-zinc-800/70 border border-zinc-200 dark:border-zinc-700 backdrop-blur-md">
            <flux:icon.sparkles class="size-4 text-blue-700 dark:text-emerald-400" />
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-200">
                Platform Pembelajaran Modern
            </span>
        </div>
        <!-- Heading -->
        <h2 class="mt-8 text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-zinc-900 dark:text-white">
            Belajar Lebih Cepat,
            <span class="block mt-2 pb-3 bg-gradient-to-r from-blue-700 to-emerald-500 bg-clip-text text-transparent">
                Berkembang Lebih Jauh
            </span>
        </h2>
        <!-- Description -->
        <p class="mt-8 text-base sm:text-lg md:text-xl max-w-2xl mx-auto leading-relaxed text-zinc-600 dark:text-zinc-300">
            Akses berbagai kursus, ikuti event eksklusif,
            kumpulkan sertifikat, dan tingkatkan kemampuanmu
            bersama komunitas pembelajar yang terus berkembang.
        </p>
        <!-- CTA -->
        <div class="mt-12">
            <a href="{{ route('register') }}">
                <div class="inline-block rounded-2xl p-[1px] hover:scale-105 transition-all duration-300 bg-gradient-to-r from-blue-700 to-emerald-500 shadow-lg shadow-emerald-500/20">
                    <flux:button class="!rounded-[15px] !bg-white dark:!bg-zinc-900 !text-blue-700 dark:!text-emerald-400 !font-semibold !px-10 !py-3">
                        Daftar Sekarang
                    </flux:button>
                </div>
            </a>
        </div>
    </div>
</section>