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

    <form wire:submit="register" class="relative z-10 w-full max-w-5xl">

        <flux:card class="overflow-hidden rounded-3xl border border-zinc-200 dark:border-zinc-800
            bg-white/80 dark:bg-zinc-900/80
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
                        <div class="space-y-3 pt-3">

                            <flux:button
                                type="submit"
                                variant="ghost"
                                class="w-full h-11">

                                Create Account

                            </flux:button>

                            <flux:button
                                href="{{ route('login') }}"
                                wire:navigate
                                variant="ghost"
                                class="w-full">

                                Already have an account?

                            </flux:button>

                        </div>

                    </div>

                </div>

                <!-- RIGHT SIDE (BRANDING) -->
                <div class="hidden lg:flex flex-col justify-between p-10
                    border-l border-zinc-200 dark:border-zinc-800">

                    <div>

                        <flux:badge color="indigo" class="mb-6 px-4 py-1">
                            Join Inovindo LMS
                        </flux:badge>

                        <flux:heading size="2xl" class="text-zinc-900 dark:text-white leading-tight">
                            Start Your Journey.
                        </flux:heading>

                        <flux:text class="mt-5 text-zinc-600 dark:text-zinc-400 leading-relaxed text-base">
                            Unlock access to courses,
                            live events, gamified learning,
                            and collaborative experiences.
                        </flux:text>

                    </div>

                    <!-- FEATURE LIST -->
                    <div class="space-y-5 mt-10">

                        <div class="flex items-start gap-4">

                            <div class="w-11 h-11 rounded-2xl bg-indigo-500/10 flex items-center justify-center">
                                <flux:icon.academic-cap variant="mini" class="text-indigo-500" />
                            </div>

                            <div>
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    Interactive Learning
                                </p>

                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    Learn through modules and lessons.
                                </p>
                            </div>

                        </div>

                        <div class="flex items-start gap-4">

                            <div class="w-11 h-11 rounded-2xl bg-pink-500/10 flex items-center justify-center">
                                <flux:icon.users variant="mini" class="text-pink-500" />
                            </div>

                            <div>
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    Community & Events
                                </p>

                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    Participate in discussions and events.
                                </p>
                            </div>

                        </div>

                        <div class="flex items-start gap-4">

                            <div class="w-11 h-11 rounded-2xl bg-emerald-500/10 flex items-center justify-center">
                                <flux:icon.trophy variant="mini" class="text-emerald-500" />
                            </div>

                            <div>
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    Gamified Progress
                                </p>

                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    Earn points and climb the leaderboard.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </flux:card>

    </form>

</div>