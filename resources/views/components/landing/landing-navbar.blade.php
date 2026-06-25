<flux:header class="sticky top-0 z-50 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 p-6">

    {{-- Logo --}}
    <a href="#">
        <div class="flex items-center gap-3">
            <img
                src="{{ asset('images/logo-transparan.webp') }}"
                class="w-28 h-auto">
        </div>
    </a>

    <flux:spacer />

    {{-- Navigation --}}
    <div class="hidden md:flex items-center gap-8">

        <a href="#features"
            class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-blue-700 dark:hover:text-emerald-400 transition">
            Features
        </a>

        <a href="#courses"
            class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-blue-700 dark:hover:text-emerald-400 transition">
            Courses
        </a>

        <a href="#values"
            class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-blue-700 dark:hover:text-emerald-400 transition">
            Values
        </a>

        <a href="#certificate"
            class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-blue-700 dark:hover:text-emerald-400 transition">
            Certificate
        </a>

        <a href="#events"
            class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-blue-700 dark:hover:text-emerald-400 transition">
            Events
        </a>

        <a href="#testimonials"
            class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-blue-700 dark:hover:text-emerald-400 transition">
            Testimonials
        </a>

    </div>

    <flux:spacer />

    {{-- Auth --}}
    <div class="flex items-center gap-3">
        <flux:button
            x-data
            x-on:click="$flux.dark = ! $flux.dark"
            icon="moon"
            variant="subtle"
            class="hover:rotate-12 transition" />
        <a href="{{ route('login') }}">
            <flux:button variant="ghost">
                Login
            </flux:button>
        </a>

        <a href="{{ route('register') }}">
            <div class="
                    inline-block
                    rounded-2xl
                    p-[1px]

                    hover:scale-105 transition-all duration-300

                    bg-gradient-to-r
                    from-blue-700
                    to-emerald-500
                    

                    
                ">
                <flux:button class="!rounded-[15px] dark:!bg-zinc-900">
                    Register
                </flux:button>
            </div>
        </a>

    </div>

</flux:header>