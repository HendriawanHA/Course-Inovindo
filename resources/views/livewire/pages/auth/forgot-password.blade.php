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

        <!-- BACK LAYER 1 -->
        <div class="absolute -bottom-2 -right-2
        w-full h-full
        rounded-3xl
        bg-gradient-to-tr from-blue-700 to-emerald-500
        -z-20">
        </div>

        <!-- BACK LAYER 2 -->
        <div class="absolute -bottom-2 -right-2
        w-full h-full
        rounded-3xl
        bg-gradient-to-tr from-blue-600/40 to-emerald-400/30
        -z-10">
        </div>

        <!-- MAIN CARD -->
        <flux:card class="relative overflow-hidden
        border border-zinc-200 dark:border-zinc-800
        bg-white dark:bg-zinc-900
        backdrop-blur-2xl
        shadow-2xl
        rounded-3xl
        p-8">

            <!-- INNER GLOW -->
            <div class="absolute inset-0
            bg-gradient-to-br
            from-white/[0.08]
            to-transparent
            pointer-events-none">
            </div>

            <div class="relative z-10">

                <!-- HEADER -->
                <div class="text-center mb-8">

                    <!-- ICON -->
                    <div class="mx-auto mb-5
                    w-14 h-14
                    rounded-2xl
                    bg-blue-600/10
                    flex items-center justify-center">

                        <flux:icon.lock-closed
                            variant="mini"
                            class="text-blue-700 size-6" />

                    </div>

                    <flux:heading
                        size="xl"
                        class="text-zinc-900 dark:text-white font-bold">

                        Forgot Password

                    </flux:heading>

                    <flux:text class="mt-3 text-zinc-600 dark:text-zinc-400 leading-relaxed">

                        Enter your email address and we'll send
                        you a password reset link.

                    </flux:text>

                </div>

                <!-- STATUS -->
                <x-auth-session-status
                    class="mb-5"
                    :status="session('status')" />

                <!-- FORM -->
                <form wire:submit="sendPasswordResetLink" class="space-y-6">

                    <flux:field>

                        <flux:label class="gap-2 mb-3">
                            <flux:icon.envelope variant="outline" class="size-6 text-blue-700" />
                            Email Address
                        </flux:label>

                        <flux:input
                            wire:model="email"
                            type="email"
                            placeholder="you@example.com" />

                        <flux:error name="email" />

                    </flux:field>

                    <!-- BUTTONS -->
                    <div class="space-y-3 pt-2">

                        <flux:button
                            type="submit"
                            class="w-full h-11
                        !bg-blue-700
                        hover:!bg-blue-600
                        !text-white
                        rounded-xl
                        font-medium
                        shadow-lg shadow-blue-600/20">

                            Send Reset Link

                        </flux:button>

                        <flux:link
                            href="{{ route('login') }}"
                            wire:navigate
                            variant="subtle"
                            class="flex items-center justify-center text-sm">

                            Back to login

                        </flux:link>

                    </div>

                </form>

            </div>

        </flux:card>

    </div>

</div>