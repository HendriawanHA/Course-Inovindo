<section
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
                name: 'Sarah Wijaya',
                role: 'Siswa',
                text: 'Sertifikat yang diberikan sangat membantu untuk menambah portofolio profesional saya.'
            }
        ]
    }"
    class="bg-white py-24 overflow-hidden">

    <div class="text-center mb-14">

        <h2 class="text-4xl font-bold">
            Trusted by Learners
        </h2>

        <p class="mt-3 text-zinc-500">
            Join thousands of learners improving their skills.
        </p>

    </div>

    <div class="relative overflow-hidden">

        <!-- Fade kiri -->
        <div class="absolute left-0 top-0 h-full w-32 bg-gradient-to-r from-white dark:from-zinc-950 to-transparent z-10"></div>

        <!-- Fade kanan -->
        <div class="absolute right-0 top-0 h-full w-32 bg-gradient-to-l from-white dark:from-zinc-950 to-transparent z-10"></div>

        <div class="testimonial-track flex gap-8">

            <template
                x-for="(item,index) in testimonials.concat(testimonials)"
                :key="index">
                <x-landing.card-wrapper>

                    <flux:card
                        class="w-[380px] h-[360px] shrink-0 flex flex-col items-center text-center p-8">

                        <img
                            :src="'https://ui-avatars.com/api/?name=' + encodeURIComponent(item.name)"
                            class="w-16 h-16 rounded-full object-cover">

                        <h3
                            class="mt-5 text-lg font-semibold"
                            x-text="item.name">
                        </h3>

                        <p
                            class="text-sm text-blue-600 mt-1"
                            x-text="item.role">
                        </p>

                        <div class="mt-6 flex-1 flex flex-col justify-center">

                            <svg
                                class="w-8 h-8 mx-auto text-blue-600 mb-4"
                                fill="currentColor"
                                viewBox="0 0 24 24">

                                <path d="M7 17H3l3-8h4l-3 8zm11 0h-4l3-8h4l-3 8z" />

                            </svg>

                            <p
                                class="italic leading-relaxed text-zinc-600 dark:text-zinc-400"
                                x-text="item.text">
                            </p>

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