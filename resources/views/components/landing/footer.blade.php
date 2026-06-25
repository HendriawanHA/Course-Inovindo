<footer class="border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 py-6">
    <div
        class="max-w-7xl mx-auto px-6
        flex flex-col md:flex-row
        items-center justify-between gap-4">

        <div class="flex items-center gap-3">

            <img
                src="{{ asset('images/logo.webp') }}"
                class="w-28 h-auto">
        </div>
        <p class="text-sm text-zinc-500">
            © {{ date('Y') }} Inovindo Digital Media
        </p>

        <div class="flex items-center gap-5">

            <a href="#">
                <i class="fa-brands fa-youtube text-xl text-zinc-500 hover:text-red-500 transition"></i>
            </a>

            <a href="#">
                <i class="fa-brands fa-instagram text-xl text-zinc-500 hover:text-pink-500 transition"></i>
            </a>

            <a href="#">
                <i class="fa-brands fa-linkedin text-xl text-zinc-500 hover:text-blue-500 transition"></i>
            </a>

            <a href="#">
                <i class="fa-solid fa-globe text-xl text-zinc-500 hover:text-emerald-500 transition"></i>
            </a>

        </div>

    </div>

</footer>