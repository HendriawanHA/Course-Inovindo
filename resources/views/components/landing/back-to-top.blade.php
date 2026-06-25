<div
    x-data="{ show: false }"

    x-init="
        window.addEventListener('scroll', () => {
            show = window.scrollY > 500
        })
    ">

    <button
        x-show="show"
        x-transition

        @click="
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            })
        "

        class="
            fixed
            bottom-6
            right-6
            z-50

            rounded-full

            p-[2px]

            bg-gradient-to-r
            from-blue-700
            to-emerald-500

            shadow-lg
            shadow-emerald-500/20

            hover:scale-110
            transition-all
            duration-300
        ">

        <div
            class="
                w-12
                h-12

                rounded-full

                bg-white
                dark:bg-zinc-900

                flex
                items-center
                justify-center
            ">

            <flux:icon.arrow-up
                class="
                    size-5
                    text-blue-700
                    dark:text-emerald-400
                " />

        </div>

    </button>

</div>