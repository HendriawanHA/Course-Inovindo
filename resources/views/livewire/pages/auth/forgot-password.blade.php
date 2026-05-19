<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 flex items-center justify-center p-6 relative overflow-hidden">

    <!-- Gradient Blur -->
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-indigo-500/10 blur-3xl rounded-full"></div>

    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-fuchsia-500/10 blur-3xl rounded-full"></div>

    <!-- Grid Effect -->
    <div class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:40px_40px]"></div>

    <!-- CONTENT -->
    <div class="relative z-10 w-full max-w-md">

        <!-- HEADER -->
        <div class="text-center mb-8">

            <flux:badge color="indigo" class="mb-5 px-4 py-1">
                Account Recovery
            </flux:badge>

            <flux:heading size="xl" class="text-white font-bold">
                Forgot Password
            </flux:heading>

            <flux:text class="mt-3 text-zinc-400 leading-relaxed">
                Enter your email address and we’ll send
                you a password reset link.
            </flux:text>

        </div>

        <!-- GLASS CARD -->
        <flux:card class="border border-zinc-200 dark:border-zinc-800
            bg-white/80 dark:bg-zinc-900/80
            backdrop-blur-2xl
            shadow-2xl
            rounded-3xl
            p-8
            space-y-6">

            <!-- INNER GLOW -->
            <div class="absolute inset-0 bg-gradient-to-br from-white/[0.07] to-transparent pointer-events-none"></div>

            <div class="relative z-10">

                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')" />

                <form wire:submit="sendPasswordResetLink" class="space-y-6">

                    <!-- Email -->
                    <flux:field>

                        <flux:label class="mb-3">Email Address</flux:label>

                        <flux:input
                            wire:model="email"
                            type="email"
                            placeholder="you@example.com" />

                        <flux:error name="email" />

                    </flux:field>

                    <!-- BUTTONS -->
                    <div class="space-y-3">

                        <flux:button
                            type="submit"
                            variant="ghost"
                            class="w-full h-11 text-sm font-semibold">

                            Send Reset Link

                        </flux:button>

                        <flux:button
                            href="{{ route('login') }}"
                            wire:navigate
                            variant="ghost"
                            class="w-full">

                            Back to login

                        </flux:button>

                    </div>

                </form>

            </div>

        </flux:card>

    </div>

</div>