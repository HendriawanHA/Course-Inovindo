<div class="relative">
    <button
        type="button"
        wire:click="toggle"
        class="flex items-center gap-3 rounded-2xl border border-zinc-800 bg-zinc-950 px-3 py-2 hover:bg-zinc-800"
    >
        <img
            src="{{ auth()->user()?->avatar
                ? asset('storage/' . auth()->user()->avatar)
                : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
            class="h-10 w-10 rounded-full object-cover"
        >

        <div class="hidden text-left md:block">
            <p class="text-sm font-semibold text-white">
                {{ auth()->user()->name }}
            </p>

            <p class="text-xs text-zinc-400">
                Instructor
            </p>
        </div>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 text-zinc-400 transition {{ $open ? 'rotate-180' : '' }}"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    @if ($open)
        <div
            wire:click.outside="close"
            class="absolute right-0 z-50 mt-3 w-64 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900 shadow-2xl shadow-black/40"
        >
            <div class="border-b border-zinc-800 px-4 py-4">
                <p class="font-semibold text-white">
                    {{ auth()->user()->name }}
                </p>

                <p class="mt-1 truncate text-sm text-zinc-400">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <div class="p-2">
                <a
                    href="{{ route('instructor.profile') }}"
                    wire:navigate
                    class="flex items-center rounded-xl px-4 py-3 text-sm font-medium text-zinc-300 transition hover:bg-zinc-800 hover:text-white"
                >
                    Account Settings
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center rounded-xl px-4 py-3 text-sm font-medium text-red-400 transition hover:bg-red-500/10"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
