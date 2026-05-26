<?php

namespace App\Livewire\Instructor\Courses;
use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.instructor')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.instructor.courses.index', [
            'courses' => Course::where('user_id', auth()->id())
                ->withCount(['modules', 'discussions'])
                ->latest()
                ->get(),
        ]);
    }
}
