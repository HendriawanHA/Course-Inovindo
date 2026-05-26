<div class="space-y-8">

    <div>
        <h1 class="text-3xl font-bold text-white">Profile</h1>
        <p class="mt-2 text-sm text-zinc-400">
            Kelola informasi akun instruktur.
        </p>
    </div>

    <section class="rounded-3xl border border-zinc-800 bg-zinc-900 p-6">
        <div class="flex flex-col gap-6 md:flex-row md:items-center">
            <div>


                <div class="mt-6 flex items-center gap-6">

                    <div class="relative">

                        {{-- AVATAR --}}
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}"
                                class="h-32 w-32 rounded-full object-cover ring-4 ring-zinc-800">
                        @elseif (auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                class="h-32 w-32 rounded-full object-cover ring-4 ring-zinc-800">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                                class="h-32 w-32 rounded-full object-cover ring-4 ring-zinc-800">
                        @endif

                        {{-- LOADING OVERLAY --}}
                        <div wire:loading.flex wire:target="avatar"
                            class="absolute inset-0 items-center justify-center rounded-full bg-black/70 backdrop-blur-sm">
                            <svg class="h-6 w-6 animate-spin text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>

                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                        </div>

                        {{-- EDIT BUTTON --}}
                        <label for="avatar-upload"
                            class="absolute bottom-1 right-1 flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border-4 border-zinc-900 bg-indigo-600 text-white shadow-lg transition hover:scale-110 hover:bg-indigo-500">
                            {{-- PEN ICON --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.232 5.232l3.536 3.536M9 13l6.768-6.768a2.5 2.5 0 113.536 3.536L12.536 16.536a4 4 0 01-1.414.95L7 19l1.514-4.122A4 4 0 019 13z" />
                            </svg>

                            <input id="avatar-upload" type="file" wire:model="avatar" class="hidden">
                        </label>

                    </div>



                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-white">
                    {{ auth()->user()->name }}
                </h2>

                <p class="mt-1 text-sm text-zinc-400">
                    {{ auth()->user()->email }}
                </p>

                <span
                    class="mt-3 inline-flex rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-semibold text-indigo-300">
                    Instructor
                </span>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-zinc-800 bg-zinc-900 p-6">
        <h2 class="text-xl font-bold text-white">Account Information</h2>
        <div class="mt-6 space-y-5">
            <div>
                <label class="text-sm font-semibold text-white">Name</label>
                <input type="text" wire:model="name"
                    class="mt-2 w-full rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:ring-indigo-500">
                @error('name')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-white">Email</label>
                <input type="email" wire:model="email"
                    class="mt-2 w-full rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:ring-indigo-500">
                @error('email')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <button wire:click="updateProfile"
                class="rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                Save Profile
            </button>
        </div>
    </section>

    <section class="rounded-3xl border border-zinc-800 bg-zinc-900 p-6">
        <h2 class="text-xl font-bold text-white">Change Password</h2>

        <div class="mt-6 space-y-5">
            <input type="password" wire:model="current_password" placeholder="Current password"
                class="w-full rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white">
            @error('current_password')
                <p class="text-sm text-red-400">{{ $message }}</p>
            @enderror

            <input type="password" wire:model="password" placeholder="New password"
                class="w-full rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white">
            @error('password')
                <p class="text-sm text-red-400">{{ $message }}</p>
            @enderror

            <input type="password" wire:model="password_confirmation" placeholder="Confirm new password"
                class="w-full rounded-2xl border border-zinc-700 bg-zinc-800 px-4 py-3 text-sm text-white">

            <button wire:click="updatePassword"
                class="rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                Update Password
            </button>
        </div>
    </section>

</div>
