<?php

namespace App\Livewire\Instructor\Students;

use App\Livewire\Concerns\WithSearch;
use App\Models\Enrollment;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.instructor')]
class Index extends Component
{
    use WithSearch;

    public function render()
    {
        $search = $this->searchTerm();

        $enrollments = Enrollment::query()
            ->whereHas('course', function ($query) {
                $query->where('user_id', auth()->id());
            })
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
            ->get();

        return view('livewire.instructor.students.index', [
            'enrollments' => $enrollments,
            'search' => $search,
        ]);
    }
}
