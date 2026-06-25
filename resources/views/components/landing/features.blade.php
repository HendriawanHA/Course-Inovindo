<section class="bg-zinc-100 mx-auto px-60 py-24">

    <div class="text-center">

        <h2 class="text-4xl font-bold">
            Your Learning Journey Made Easy
        </h2>

        <p class="mt-4 text-zinc-500">
            Belajar dengan alur yang sederhana.
        </p>

    </div>

    <div class="grid lg:grid-cols-2 gap-16 items-center mt-16">

        <!-- ILUSTRASI -->
        <div>
            <img
                src="{{ asset('images/illust-learning.png') }}"
                alt="Learning Illustration"
                class="w-full max-w-xl mx-auto">
        </div>

        <!-- STEP CARD -->
        <div class="space-y-8">

            <div class="mr-12">
                <x-landing.card-wrapper>
                    <flux:card class="flex justify-evenly items-center py-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
                        <div class="text-4xl font-bold text-blue-700">
                            01
                        </div>
                        <div class="flex flex-col">
                            <h3 class="mt-4 font-semibold">
                                Choose Course
                            </h3>

                            <p class="mt-2 text-zinc-500">
                                Pilih kursus sesuai kebutuhanmu.
                            </p>
                        </div>
                    </flux:card>
                </x-landing.card-wrapper>
            </div>

            <div class="ml-12">
                <x-landing.card-wrapper>
                    <flux:card class="flex justify-evenly items-center py-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
                        <div class="flex flex-col">
                            <h3 class="mt-4 font-semibold">
                                Learn Anywhere
                            </h3>

                            <p class="mt-2 text-zinc-500">
                                Belajar dari perangkat apa saja.
                            </p>
                        </div>
                        <div class="text-4xl font-bold text-emerald-500">
                            02
                        </div>

                    </flux:card>
                </x-landing.card-wrapper>
            </div>

            <div class="mr-12">
                <x-landing.card-wrapper>
                    <flux:card class="flex justify-evenly items-center py-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-700/20 hover:border-emerald-500">
                        <div class="text-4xl font-bold text-blue-700">
                            03
                        </div>
                        <div class="flex flex-col">
                            <h3 class="font-semibold">
                                Earn Certificate
                            </h3>

                            <p class="text-zinc-500">
                                Dapatkan sertifikat setelah selesai.
                            </p>
                        </div>
                    </flux:card>
                </x-landing.card-wrapper>
            </div>

        </div>

    </div>

</section>