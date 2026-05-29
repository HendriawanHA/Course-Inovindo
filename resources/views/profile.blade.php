<x-app-layout>

    <flux:main class="p-8 bg-zinc-50 dark:bg-zinc-900">

        <div class="max-w-6xl mx-auto">

            <!-- Header -->
            <div class="flex items-center gap-6 mb-10">

                <img
                    src="{{ auth()->user()->avatar
                        ? asset('storage/' . auth()->user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                    class="w-24 h-24 rounded-full object-cover border-4 border-white dark:border-zinc-800 shadow-lg">

                <div>

                    <flux:heading size="xl" class="text-zinc-900 dark:text-white">
                        {{ auth()->user()->name }}
                    </flux:heading>

                    <flux:text class="text-zinc-500 mt-1">
                        {{ auth()->user()->headline ?? 'No headline yet' }}
                    </flux:text>

                    <flux:text class="mt-3 text-sm max-w-xl text-zinc-600 dark:text-zinc-400">
                        {{ auth()->user()->bio ?? 'No bio added yet.' }}
                    </flux:text>

                </div>

            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left -->
                <div class="lg:col-span-2 space-y-6">

                    <flux:card class="p-6">
                        <livewire:profile.update-profile-information-form />
                    </flux:card>

                    <flux:card class="p-6">
                        <livewire:profile.update-password-form />
                    </flux:card>

                </div>

                <!-- Right -->
                <div>

                    <flux:card class="p-6 border border-red-500/20">

                        <flux:heading class="text-red-500">
                            Danger Zone
                        </flux:heading>

                        <flux:text class="mt-2 text-sm text-zinc-500">
                            Permanently delete your account and all related data.
                        </flux:text>

                        <div class="mt-6">
                            <livewire:profile.delete-user-form />
                        </div>

                    </flux:card>

                </div>

            </div>

        </div>

    </flux:main>

</x-app-layout>