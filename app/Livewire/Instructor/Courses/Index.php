<?php

namespace App\Livewire\Instructor\Courses;
use App\Livewire\Concerns\WithSearch;
use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.instructor')]
class Index extends Component
{
    use WithSearch;

    public function render()
    {
        $search = $this->searchTerm();

        return view('livewire.instructor.courses.index', [
            'courses' => Course::where('user_id', auth()->id())
                ->when($search !== '', fn($query) => $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                }))
                ->withCount(['modules', 'lessons', 'discussions'])
                ->latest()
                ->get(),
            'search' => $search,
        ]);
    }
}
