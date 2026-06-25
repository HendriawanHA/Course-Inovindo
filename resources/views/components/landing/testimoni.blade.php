<section id="testimonials" class="bg-white dark:bg-zinc-900 py-24 overflow-hidden relative"
    x-data="{
        testimonials: [
         {
            name: 'Hendriawan',
            role: 'Mahasiswa',
            text: 'Kursus Laravel sangat membantu saya memahami web development dari dasar hingga deployment.'
         },
         {
            name: 'Adi Mulyadi',
            role: 'Mahasiswa',
            text: 'Materi mudah dipahami dan progress tracking membuat saya lebih termotivasi belajar.'
         },
         {
            name: 'Rahmat Tahalu Asik',
            role: 'Siswa',
            text: 'Sertifikat yang diberikan sangat membantu untuk menambah portofolio profesional saya.'
         }
     ]}">
    <x-landing.dark-bg />
    <div class="text-center mb-14">
        <div class="flex items-center justify-center gap-6 mb-5">
            <div class="h-[3px] w-10 md:w-20 rounded-full bg-gradient-to-r from-blue-700 to-emerald-500"></div>
            <div class="flex items-center gap-2">
                <!-- Sparkle Biru -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 md:w-12 md:h-12 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l2.2 5.8L20 10l-5.8 2.2L12 18l-2.2-5.8L4 10l5.8-2.2L12 2z" />
                </svg>
                <!-- Sparkle Emerald -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-10 md:h-10 text-emerald-500 translate-y-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l2.2 5.8L20 10l-5.8 2.2L12 18l-2.2-5.8L4 10l5.8-2.2L12 2z" />
                </svg>
            </div>
            <div class="h-[3px] w-10 md:w-20 rounded-full bg-gradient-to-l from-blue-700 to-emerald-500"></div>
        </div>
        <div>
            <h2 class="text-3xl md:text-5xl font-bold text-zinc-900 dark:text-white px-6">
                Dipercaya oleh
                <span class="bg-gradient-to-r from-blue-700 to-emerald-500 bg-clip-text text-transparent">
                    Pembelajar
                </span>
            </h2>
        </div>
        <p class="mt-3 text-zinc-500 dark:text-zinc-400 px-6">
            Yuk, tingkatkan skill kamu bersama pembelajar lainnya!
        </p>
    </div>
    <div class="relative overflow-hidden pt-6 pb-8">
        <!-- Fade kiri -->
        <div class="absolute left-0 top-0 h-full w-24 bg-gradient-to-r from-white dark:from-zinc-900 to-transparent z-10"></div>
        <!-- Fade kanan -->
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-white dark:from-zinc-900 to-transparent z-10"></div>
        <div class="testimonial-track flex gap-8">
            <template x-for="(item,index) in testimonials.concat(testimonials)" :key="index">
                <x-landing.card-wrapper>
                    <flux:card class=" w-[300px] md:w-[380px] h-[360px] shrink-0 flex flex-col items-center text-center p-8 bg-white dark:bg-zinc-900/95 border border-zinc-200 dark:border-zinc-700 backdrop-blur-md transition-all duration-300 hover:-translate-y-2">
                        <img :src="'https://ui-avatars.com/api/?name=' + encodeURIComponent(item.name)" class="w-16 h-16 rounded-full object-cover ring-2 ring-zinc-200 dark:ring-zinc-700">
                        <h3 class="mt-5 text-lg font-semibold text-zinc-900 dark:text-white" x-text="item.name"></h3>
                        <p class="text-sm text-blue-600 mt-1 dark:text-blue-400" x-text="item.role"></p>
                        <div class="mt-6 flex-1 flex flex-col justify-center">
                            <svg class="w-8 h-8 mx-auto text-blue-600 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 17H3l3-8h4l-3 8zm11 0h-4l3-8h4l-3 8z" />
                            </svg>
                            <p class="italic leading-relaxed text-zinc-600 dark:text-zinc-400" x-text="item.text"></p>
                        </div>
                    </flux:card>
                </x-landing.card-wrapper>
            </template>
        </div>
    </div>
</section>
<style>
    .testimonial-track {
        width: max-content;
        animation: testimonial-scroll 30s linear infinite;
    }

    .testimonial-track:hover {
        animation-play-state: paused;
    }

    @keyframes testimonial-scroll {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }
</style>