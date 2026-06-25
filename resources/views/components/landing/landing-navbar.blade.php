<flux:header class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 p-6">

    {{-- Logo --}}
    <div class="flex items-center gap-3">
        <img
            src="{{ asset('images/logo-transparan.webp') }}"
            class="w-28 h-auto">

    </div>

    <flux:spacer />

    {{-- Navigation --}}
    <div class="hidden md:flex items-center gap-6">

        <a href="#courses"
            class="text-sm text-zinc-600 hover:text-zinc-900">
            Courses
        </a>

        <a href="#events"
            class="text-sm text-zinc-600 hover:text-zinc-900">
            Events
        </a>

        <a href="#about"
            class="text-sm text-zinc-600 hover:text-zinc-900">
            About
        </a>

    </div>

    <flux:spacer />

    {{-- Auth --}}
    <div class="flex items-center gap-3">

        <a href="{{ route('login') }}">
            <flux:button variant="ghost">
                Login
            </flux:button>
        </a>

        <a href="{{ route('register') }}">
            <flux:button class="!bg-blue-700 !text-white">
                Register
            </flux:button>
        </a>

    </div>

</flux:header>