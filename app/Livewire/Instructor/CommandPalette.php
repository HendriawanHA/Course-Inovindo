<?php

namespace App\Livewire\Instructor;

use App\Models\Course;
use App\Models\Discussion;
use App\Models\Enrollment;
use Livewire\Attributes\On;
use Livewire\Component;

class CommandPalette extends Component
{
    public bool $open = false;
    public string $search = '';

    #[On('open-command-palette')]
    public function openPalette(): void
    {
        $this->open = true;
        $this->search = '';
    }

    public function closePalette(): void
    {
        $this->open = false;
        $this->search = '';
    }

    public function updatedSearch(): void
    {
        // Trigger re-render when search changes
    }

    public function getCoursesProperty()
    {
        $term = trim($this->search);

        return Course::where('user_id', auth()->id())
            ->when($term !== '', fn($q) => $q->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            }))
            ->withCount('lessons')
            ->latest()
            ->take(5)
            ->get();
    }

    public function getStudentsProperty()
    {
        $term = trim($this->search);

        return Enrollment::whereHas('course', fn($q) => $q->where('user_id', auth()->id()))
            ->whereHas('user', fn($q) => $q->where('role', 'student'))
            ->when($term !== '', fn($q) => $q->where(function ($q) use ($term) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%"))
                    ->orWhereHas('course', fn($q) => $q->where('title', 'like', "%{$term}%"));
            }))
            ->with(['user', 'course'])
            ->distinct('user_id')
            ->latest()
            ->take(5)
            ->get();
    }

    public function getDiscussionsProperty()
    {
        $term = trim($this->search);

        return Discussion::whereHas('course', fn($q) => $q->where('user_id', auth()->id()))
            ->when($term !== '', fn($q) => $q->where(function ($q) use ($term) {
                $q->where('content', 'like', "%{$term}%")
                    ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$term}%"))
                    ->orWhereHas('lesson', fn($q) => $q->where('title', 'like', "%{$term}%"));
            }))
            ->with(['user', 'course', 'lesson'])
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.instructor.command-palette');
    }
}
