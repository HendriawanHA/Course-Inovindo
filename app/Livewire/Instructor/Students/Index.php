<?php

namespace App\Livewire\Instructor\Students;

use App\Livewire\Concerns\WithSearch;
use App\Models\Course;
use App\Models\Enrollment;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.instructor')]
class Index extends Component
{
    use WithSearch;
    use WithPagination;

    #[Url(as: 'course', except: '')]
    public string $courseId = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCourseId(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = $this->searchTerm();

        $courses = Course::query()
            ->where('user_id', auth()->id())
            ->orderBy('title')
            ->get(['id', 'title']);

        $enrollments = Enrollment::query()
            ->whereHas('course', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->when($this->courseId !== '', fn($query) => $query->where('course_id', $this->courseId))
            ->when($search !== '', fn($query) => $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('course', function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%");
                });
            }))
            ->with(['user', 'course'])
            ->latest()
            ->paginate(10);

        return view('livewire.instructor.students.index', [
            'courses' => $courses,
            'enrollments' => $enrollments,
            'search' => $search,
        ]);
    }
}
