<?php

namespace App\Livewire\Instructor;

use Livewire\Component;

class ProfileDropdown extends Component
{
    public bool $open = false;

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function close(): void
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.instructor.profile-dropdown');
    }
}
