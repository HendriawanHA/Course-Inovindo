<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirect(route('redirect.after.login', absolute: false), navigate: true);
    }
};
?>

<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 flex items-center justify-center p-6 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-[400px] h-[400px] bg-indigo-500/10 blur-3xl rounded-full"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-fuchsia-500/10 blur-3xl rounded-full"></div>
    <div
        class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:40px_40px]">
    </div>

    <form wire:submit="login" class="relative z-10 w-full max-w-5xl">
        <div
            class="absolute -bottom-2 -right-2
        w-full h-full
        rounded-3xl
        bg-gradient-to-tr from-blue-700 to-emerald-500
        opacity-90
        -z-20">
        </div>

        <div
            class="absolute -bottom-2 -right-2
        w-full h-full
        rounded-3xl
        bg-gradient-to-tr from-blue-600/40 to-emerald-400/30
        -z-10">
        </div>

        <flux:card
            class="relative overflow-hidden rounded-3xl border border-zinc-200 dark:border-zinc-800
        bg-white dark:bg-zinc-900
        backdrop-blur-2xl
        shadow-2xl">
            <div class="grid lg:grid-cols-2">
                <div
                    class="hidden lg:flex flex-col justify-evenly p-10
                    border-r border-zinc-200 dark:border-zinc-800">
                    <div class="mb-4">
                        <div>
                            <h1
                                class="flex justify-center items-center text-xl font-bold text-green-500 dark:text-greenn-500 tracking-tight">
                                <flux:icon name="book-open" class="inline w-6 h-6 mr-2 text-blue-700" />
                                <div class="flex gap-1">
                                    <span class="text-blue-700">Inovindo</span>
                                    Course
                                </div>
                            </h1>
                            <p
                                class="mt-4 text-sm text-zinc-600 text-justify dark:text-zinc-400 leading-relaxed max-w-sm">
                                Platform pembelajaran modern untuk kursus interaktif, acara langsung, kolaborasi, dan
                                pendidikan berbasis gim.
                            </p>
                        </div>

                        <div class="flex justify-center">
                            <img src="{{ asset('images/illust-course.svg') }}" alt="Illustration"
                                class="w-full max-w-[380px] h-auto object-contain" />
                        </div>

                        <div class="w-full flex items-center justify-center">
                            <img src="{{ asset('images/logo-transparan.webp') }}" alt="Inovindo LMS"
                                class="w-full max-w-[180px] h-auto object-contain mt-3" />
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-center p-8 lg:p-10">
                    <h1
                        class="flex justify-center items-center text-xl lg:hidden mb-6 font-bold text-green-500 dark:text-greenn-500 tracking-tight">
                        <flux:icon name="book-open" class="inline w-6 h-6 mr-2 text-blue-700" />
                        <div class="flex gap-1">
                            <span class="text-blue-700">Inovindo</span>
                            Course
                        </div>
                    </h1>
                    <div>
                        <flux:heading size="xl" class="text-center text-zinc-900 dark:text-white">
                            Log In
                        </flux:heading>
                    </div>
                    <x-auth-session-status class="mt-6" :status="session('status')" />

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

                    <div class="space-y-5 mt-8">
                        <flux:field>
                            <flux:label class="mb-3 gap-2">
                                <flux:icon.envelope variant="outline" class="size-6 text-blue-700" />
                                Email
                            </flux:label>
                            <flux:input wire:model="form.email" type="email" placeholder="you@example.com" />
                            <flux:error name="form.email" />
                        </flux:field>

                        <flux:field>
                            <div class="mb-3 flex justify-between items-center">
                                <flux:label class="gap-2">
                                    <flux:icon.lock-closed variant="outline" class="size-6 text-blue-700" />
                                    Password
                                </flux:label>
                                <flux:link href="{{ route('password.request') }}" wire:navigate variant="subtle"
                                    class="text-sm">
                                    Forgot password?
                                </flux:link>
                            </div>
                            <flux:input wire:model="form.password" type="password" placeholder="••••••••" />
                            <flux:error name="form.password" />
                        </flux:field>

                        <label class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                            <input wire:model="form.remember" type="checkbox"
                                class="rounded border-zinc-300 dark:border-zinc-700">
                            Remember me
                        </label>

                        <div class="space-y-5 pt-3">
                            <flux:button type="submit"
                                class="w-full h-11 !text-white !bg-blue-700 hover:!bg-blue-600 font-medium shadow-lg shadow-blue-600/20 rounded-xl transition-all duration-200">
                                Log In
                            </flux:button>
                            <flux:link href="{{ route('register') }}" wire:navigate variant="subtle"
                                class="flex items-center justify-center text-sm">
                                Create account
                            </flux:link>
                        </div>

                        <div class="lg:hidden mb-8">
                            <img
                                src="{{ asset('images/logo-transparan.webp') }}"
                                alt="Inovindo LMS"
                                class="w-36 mx-auto mb-4" />
                        </div>
                    </div>
                </div>
            </div>
        </flux:card>
    </form>
</div>