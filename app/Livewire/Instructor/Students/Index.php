<?php

namespace App\Livewire\Instructor\Students;

use App\Models\Enrollment;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.instructor')]
class Index extends Component
{
    public function render()
    {
        $enrollments = Enrollment::query()
            ->whereHas('course', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with(['user', 'course'])
            ->latest()
            ->get();

        return view('livewire.instructor.students.index', [
            'enrollments' => $enrollments,
        ]);
    }
}
