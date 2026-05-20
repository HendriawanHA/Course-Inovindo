<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // otomatis role student
        $validated['role'] = 'student';

        event(new Registered($user = User::create($validated)));

        session()->flash('success', 'Account created successfully. Please login.');

        $this->redirect(route('login', absolute: false));
    }
};
?>

<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 flex items-center justify-center p-6 relative overflow-hidden">

    <!-- BACKGROUND GLOW -->
    <div class="absolute top-0 left-0 w-[400px] h-[400px] bg-indigo-500/10 blur-3xl rounded-full"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-fuchsia-500/10 blur-3xl rounded-full"></div>
    <div class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:40px_40px]"></div>


    <form wire:submit="register" class="relative z-10 w-full max-w-5xl">
        <div class="absolute -bottom-2 -right-2
        w-full h-full
        rounded-3xl
        bg-gradient-to-tr from-blue-700 to-emerald-500
        opacity-90
        -z-20">
        </div>

        <div class="absolute -bottom-2 -right-2
        w-full h-full
        rounded-3xl
        bg-gradient-to-tr from-blue-600/40 to-emerald-400/30
        -z-10">
        </div>
        <flux:card class="overflow-hidden rounded-3xl border border-zinc-200 dark:border-zinc-800
            bg-white dark:bg-zinc-900
            backdrop-blur-2xl
            shadow-2xl">

            <div class="grid lg:grid-cols-2">

                <!-- LEFT SIDE (FORM) -->
                <div class="p-8 lg:p-10">

                    <!-- MOBILE HEADER -->
                    <div class="lg:hidden mb-8 text-center">

                        <flux:badge color="indigo" class="mb-4">
                            Inovindo LMS
                        </flux:badge>

                        <flux:heading size="xl" class="text-zinc-900 dark:text-white">
                            Create Account
                        </flux:heading>

                    </div>

                    <div>

                        <flux:heading size="xl" class="text-zinc-900 dark:text-white">
                            Register
                        </flux:heading>

                        <flux:text class="mt-2 text-zinc-500 dark:text-zinc-400">
                            Create your account and start learning.
                        </flux:text>

                    </div>

                    <!-- FORM -->
                    <div class="space-y-5 mt-8">

                        <!-- Name -->
                        <flux:field>

                            <flux:label class="mb-3">Name</flux:label>

                            <flux:input
                                wire:model="name"
                                type="text"
                                placeholder="Your full name" />

                            <flux:error name="name" />

                        </flux:field>

                        <!-- Email -->
                        <flux:field>

                            <flux:label class="mb-3">Email</flux:label>

                            <flux:input
                                wire:model="email"
                                type="email"
                                placeholder="you@example.com" />

                            <flux:error name="email" />

                        </flux:field>

                        <!-- Password -->
                        <flux:field>

                            <flux:label class="mb-3">Password</flux:label>

                            <flux:input
                                wire:model="password"
                                type="password"
                                placeholder="Create password" />

                            <flux:error name="password" />

                        </flux:field>

                        <!-- Confirm Password -->
                        <flux:field>

                            <flux:label class="mb-3">Confirm Password</flux:label>

                            <flux:input
                                wire:model="password_confirmation"
                                type="password"
                                placeholder="Repeat password" />

                            <flux:error name="password_confirmation" />

                        </flux:field>

                        <!-- BUTTONS -->
                        <div class="space-y-5 pt-3">

                            <flux:button
                                type="submit"
                                variant="ghost"
                                class="w-full h-11 !text-white !bg-blue-700 hover:!bg-blue-600 font-mediumshadow-lg shadow-indigo-500/20 rounded-xl transition-all duration-200">

                                Create Account

                            </flux:button>

                            <flux:link
                                href="{{ route('login') }}"
                                wire:navigate
                                variant="subtle"
                                class="flex items-center justify-center text-sm">

                                Already have an account?

                            </flux:link>

                        </div>

                    </div>

                </div>

                <!-- RIGHT SIDE (BRANDING) -->
                <div class="hidden lg:flex flex-col justify-between p-10
                    border-l border-zinc-200 dark:border-zinc-800">

                    <div>
                        <h1 class="flex items-center text-xl font-bold text-green-500 dark:text-greenn-500 tracking-tight">
                            <flux:icon name="book-open" class="inline w-6 h-6 mr-2 text-blue-700" />
                            <div class="flex gap-1">
                                <span class="text-blue-700">Inovindo</span>
                                Course
                            </div>
                        </h1>

                        <flux:heading size="2xl" class="text-zinc-900 dark:text-white leading-tight mt-3 pl-8">
                            Start Your Journey.
                        </flux:heading>
                    </div>

                    <div class="flex justify-center">
                        <img
                            src="{{ asset('storage/images/illust-auth-course.svg') }}"
                            alt="Illustration"
                            class="w-full max-w-[380px] h-auto object-contain" />
                    </div>

                    <!-- Logo Section -->
                    <div class="w-full flex items-center justify-center">
                        <img
                            src="{{ asset('storage/images/logo-transparan.webp') }}"
                            alt="Inovindo LMS"
                            class="w-full max-w-[180px] h-auto object-contain mt-3" />
                    </div>

                </div>

            </div>

        </flux:card>

    </form>

</div>