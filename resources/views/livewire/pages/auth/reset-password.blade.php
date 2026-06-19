<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();
                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        Session::flash('status', __($status));
        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950 flex items-center justify-center p-6 relative overflow-hidden">

        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-indigo-500/10 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-fuchsia-500/10 blur-3xl rounded-full"></div>

        <div class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:40px_40px]"></div>

        <div class="relative z-10 w-full max-w-md">
            <div class="absolute -bottom-2 -right-2
                        w-full h-full
                        rounded-3xl
                        bg-gradient-to-tr from-blue-700 to-emerald-500
                        -z-20">
            </div>

            <div class="absolute -bottom-2 -right-2
    w-full h-full
    rounded-3xl
    bg-gradient-to-tr from-blue-600/40 to-emerald-400/30
    -z-10">
            </div>

            <flux:card class="relative overflow-hidden
    border border-zinc-200 dark:border-zinc-800
    bg-white dark:bg-zinc-900
    backdrop-blur-2xl
    shadow-2xl
    rounded-3xl
    p-8">

                <div class="absolute inset-0
        bg-gradient-to-br
        from-white/[0.08]
        to-transparent
        pointer-events-none">
                </div>

                <div class="relative z-10">

                    <div class="text-center mb-8">
                        <div class="flex justify-center items-center gap-2 mb-5">
                            <flux:icon.key
                                variant="mini"
                                class="text-blue-700 size-6" />

                            <flux:heading
                                size="xl"
                                class="text-zinc-900 dark:text-white font-bold">
                                Reset Password
                            </flux:heading>
                        </div>

                        <flux:text class="mt-3 hidden lg:block text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            Enter your new password below to regain access to your account.
                        </flux:text>
                    </div>

                    <form wire:submit="resetPassword" class="space-y-6">

                        <flux:field>
                            <flux:label class="gap-2 mb-3">
                                <flux:icon.envelope
                                    variant="outline"
                                    class="size-6 text-blue-700" />
                                Email Address
                            </flux:label>

                            <flux:input
                                wire:model="email"
                                type="email"
                                placeholder="you@example.com" />

                            <flux:error name="email" />
                        </flux:field>

                        <flux:field>
                            <flux:label class="gap-2 mb-3">
                                <flux:icon.lock-closed
                                    variant="outline"
                                    class="size-6 text-blue-700" />
                                New Password
                            </flux:label>

                            <flux:input
                                wire:model="password"
                                type="password"
                                placeholder="Enter new password" />

                            <flux:error name="password" />
                        </flux:field>

                        <flux:field>
                            <flux:label class="gap-2 mb-3">
                                <flux:icon.shield-check
                                    variant="outline"
                                    class="size-6 text-blue-700" />
                                Confirm Password
                            </flux:label>

                            <flux:input
                                wire:model="password_confirmation"
                                type="password"
                                placeholder="Confirm new password" />

                            <flux:error name="password_confirmation" />
                        </flux:field>

                        <div class="space-y-3 pt-2">

                            <flux:button
                                type="submit"
                                class="w-full h-11 !bg-blue-700 hover:!bg-blue-600 !text-white rounded-xl font-medium shadow-lg shadow-blue-600/20">
                                Reset Password
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

</div>