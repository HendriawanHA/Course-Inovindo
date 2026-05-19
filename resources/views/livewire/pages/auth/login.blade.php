<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false));
    }
}; ?>

<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 flex items-center justify-center p-6 relative overflow-hidden">

    <!-- BACKGROUND GLOW -->
    <div class="absolute top-0 left-0 w-[400px] h-[400px] bg-indigo-500/10 blur-3xl rounded-full"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-fuchsia-500/10 blur-3xl rounded-full"></div>

    <form wire:submit="login" class="relative z-10 w-full max-w-5xl">

        <flux:card class="overflow-hidden rounded-3xl border border-zinc-200 dark:border-zinc-800
            bg-white/80 dark:bg-zinc-900/80
            backdrop-blur-2xl
            shadow-2xl">

            <div class="grid lg:grid-cols-2">

                <!-- LEFT SIDE -->
                <div class="hidden lg:flex flex-col justify-center p-10
                    border-r border-zinc-200 dark:border-zinc-800">


                    <div class="mb-10">

                        <!-- Logo Section -->
                        <div class="w-full flex items-center justify-start mb-6">

                            <img
                                src="{{ asset('storage/images/logo-transparan.webp') }}"
                                alt="Inovindo LMS"
                                class="w-full max-w-[220px] h-auto object-contain" />

                        </div>

                        <!-- Brand Text -->
                        <div class="mt-6">

                            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white tracking-tight">
                                Inovindo Course
                            </h1>

                            <p class="mt-3 text-zinc-600 dark:text-zinc-400 leading-relaxed max-w-sm">
                                Modern learning platform for interactive courses,
                                live events, collaboration, and gamified education.
                            </p>

                        </div>

                    </div>


                    <!-- FEATURE LIST -->
                    <div class=" flex items-center justify-center gap-5">

                        <div class="flex items-start gap-4">

                            <div class="w-11 h-11 rounded-2xl bg-indigo-500/10 flex items-center justify-center">
                                <flux:icon.book-open variant="mini" class="text-indigo-500" />
                            </div>

                            <div>
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    Modern Courses
                                </p>

                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    Structured modules and lessons.
                                </p>
                            </div>

                        </div>

                        <div class="flex items-start gap-4">

                            <div class="w-11 h-11 rounded-2xl bg-pink-500/10 flex items-center justify-center">
                                <flux:icon.trophy variant="mini" class="text-pink-500" />
                            </div>

                            <div>
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    Gamified Experience
                                </p>

                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    Earn points and climb leaderboard.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT SIDE -->
                <div class="p-8 lg:p-10">

                    <!-- MOBILE HEADER -->
                    <div class="lg:hidden mb-8 text-center">

                        <flux:badge color="indigo" class="mb-4">
                            Inovindo LMS
                        </flux:badge>

                        <flux:heading size="xl" class="text-zinc-900 dark:text-white">
                            Welcome Back
                        </flux:heading>

                    </div>

                    <div>

                        <flux:heading size="xl" class="text-zinc-900 dark:text-white">
                            Log In
                        </flux:heading>

                        <flux:text class="mt-2 text-zinc-500 dark:text-zinc-400">
                            Access your learning dashboard.
                        </flux:text>

                    </div>

                    <x-auth-session-status
                        class="mt-6"
                        :status="session('status')" />

                    @if (session('success'))

                    <div class="mt-4 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3">

                        <div class="flex items-center gap-3">

                            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>

                            <p class="text-sm text-emerald-500">
                                {{ session('success') }}
                            </p>

                        </div>

                    </div>

                    @endif

                    <!-- FORM -->
                    <div class="space-y-5 mt-8">

                        <flux:field>

                            <flux:label>Email</flux:label>

                            <flux:input
                                wire:model="form.email"
                                type="email"
                                placeholder="you@example.com" />

                            <flux:error name="form.email" />

                        </flux:field>

                        <flux:field>

                            <div class="mb-3 flex justify-between items-center">

                                <flux:label>Password</flux:label>

                                <flux:link
                                    href="{{ route('password.request') }}"
                                    wire:navigate
                                    class="text-sm">

                                    Forgot password?

                                </flux:link>

                            </div>

                            <flux:input
                                wire:model="form.password"
                                type="password"
                                placeholder="••••••••" />

                            <flux:error name="form.password" />

                        </flux:field>

                        <label class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">

                            <input
                                wire:model="form.remember"
                                type="checkbox"
                                class="rounded border-zinc-300 dark:border-zinc-700">

                            Remember me

                        </label>

                        <div class="space-y-3 pt-3">

                            <flux:button
                                type="submit"
                                variant="primary"
                                class="w-full h-11">

                                Log In

                            </flux:button>

                            <flux:button
                                href="{{ route('register') }}"
                                wire:navigate
                                variant="ghost"
                                class="w-full">

                                Create account

                            </flux:button>

                        </div>

                    </div>

                </div>

            </div>

        </flux:card>

    </form>

</div>