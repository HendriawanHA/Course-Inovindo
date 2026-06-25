<section id="certificate" class="relative overflow-hidden py-20 bg-white dark:bg-zinc-900">
    <x-landing.dark-bg />
    <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- IMAGE -->
            <div class="relative order-2 lg:order-1">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-700/20 to-emerald-500/20 blur-3xl rounded-full"></div>
                <img src="{{ asset('images/illust-certificate.png') }}" class="relative w-full max-w-xl mx-auto drop-shadow-2xl transition-all duration-300 hover:scale-105">
            </div>
            <!-- CONTENT -->
            <div class="order-1 lg:order-2">
                <!-- Small Label -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-[3px] w-12 rounded-full bg-gradient-to-r from-blue-700 to-emerald-500"></div>
                    <span class="text-sm font-medium text-blue-700 dark:text-emerald-400">
                        Sertifikasi Profesional
                    </span>
                </div>
                <!-- Heading -->
                <h2 class="text-3xl md:text-5xl font-bold leading-tight text-zinc-900 dark:text-white">
                    Dapatkan
                    <span class="bg-gradient-to-r from-blue-700 to-emerald-500 bg-clip-text text-transparent">
                        Sertifikat Terverifikasi
                    </span>
                </h2>
                <!-- Description -->
                <p class="mt-6 text-lg text-zinc-600 dark:text-zinc-400 leading-relaxed">
                    Setelah menyelesaikan course, peserta akan memperoleh sertifikat digital yang dapat digunakan sebagai bukti kompetensi,
                    portofolio profesional, maupun pendukung karier.
                </p>
                <!-- BENEFITS -->
                <div class="mt-10 space-y-4">
                    <!-- Item -->
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                            <flux:icon.check-circle class="size-5 text-emerald-500" />
                        </div>
                        <span class="text-zinc-700 dark:text-zinc-300">
                            Download sertifikat dalam format PDF
                        </span>
                    </div>
                    <!-- Item -->
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                            <flux:icon.check-circle class="size-5 text-emerald-500" />
                        </div>
                        <span class="text-zinc-700 dark:text-zinc-300">
                            Nama peserta tersimpan permanen
                        </span>
                    </div>
                    <!-- Item -->
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                            <flux:icon.check-circle class="size-5 text-emerald-500" />
                        </div>
                        <span class="text-zinc-700 dark:text-zinc-300">
                            Dapat dibagikan ke LinkedIn dan Portfolio
                        </span>
                    </div>
                </div>
                <!-- VERIFIED BADGE -->
                <div class="mt-10 w-fit">
                    <div class="rounded-2xl p-[1px] bg-gradient-to-r from-blue-700 to-emerald-500 transition-all duration-300 hover:scale-105">
                        <div class="rounded-2xl bg-white dark:bg-zinc-900 p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                                    <flux:icon.check-badge class="size-6 text-emerald-500" />
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-zinc-900 dark:text-white">
                                        Sertifikat Terverifikasi
                                    </p>
                                    <p class="text-xs text-zinc-500">
                                        Download as PDF
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>