<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.instructor')]
class Preview extends Component
{
    public Course $course;

    public function mount(Course $course): void
    {
        abort_unless($course->user_id === auth()->id(), 403);

        $this->course = $course->load([
            'modules.lessons',
        ]);
    }

    public function render()
    {
        return view('livewire.instructor.courses.preview');
    }
}
