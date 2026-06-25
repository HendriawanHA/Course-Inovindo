<?php

namespace App\Livewire\Instructor\Courses;

use App\Livewire\Concerns\WithSearch;
use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.instructor')]
class Index extends Component
{
    use WithSearch;
    use WithPagination;

    #[Url(as: 'view', except: 'grid')]
    public string $view = 'grid';

    public function mount(): void
    {
        if (! in_array($this->view, ['grid', 'list'], true)) {
            $this->view = 'grid';
        }

        if (! request()->has('view')) {
            $this->view = session('instructor.courses.view', $this->view);
        }
    }

    public function updatedView(string $view): void
    {
        if (! in_array($view, ['grid', 'list'], true)) {
            $this->view = 'grid';
        }

        session(['instructor.courses.view' => $this->view]);
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = $this->searchTerm();

        return view('livewire.instructor.courses.index', [
            'courses' => Course::where('user_id', auth()->id())
                ->when($search !== '', fn($query) => $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                }))
                ->withCount(['modules', 'lessons', 'discussions', 'enrollments'])
                ->latest()
                ->paginate($this->view === 'grid' ? 9 : 10),
            'search' => $search,
        ]);
    }
}
