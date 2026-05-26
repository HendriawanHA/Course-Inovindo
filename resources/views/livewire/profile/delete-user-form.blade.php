<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
};

?>

<section class="space-y-4">

    <flux:text class="text-sm text-zinc-500">
        Once deleted, your account and all data will be permanently removed.
    </flux:text>

    <flux:modal.trigger name="delete-account">

        <flux:button variant="danger" class="mt-4">
            Delete Account
        </flux:button>

    </flux:modal.trigger>

    <flux:modal name="delete-account" class="md:w-96">

        <form wire:submit="deleteUser" class="space-y-6">

            <div>

                <flux:heading size="lg">
                    Delete Account
                </flux:heading>

                <flux:text class="mt-2 text-sm text-zinc-500">
                    Please enter your password to confirm account deletion.
                </flux:text>

            </div>

            <flux:field>

                <flux:label>Password</flux:label>

                <flux:input
                    wire:model="password"
                    type="password"
                    placeholder="Your password" />

                <flux:error name="password" />

            </flux:field>

            <div class="flex justify-end gap-3">

                <flux:modal.close>

                    <flux:button variant="ghost">
                        Cancel
                    </flux:button>

                </flux:modal.close>

                <flux:button
                    type="submit"
                    variant="danger">

                    Delete Account

                </flux:button>

            </div>

        </form>

    </flux:modal>

</section>