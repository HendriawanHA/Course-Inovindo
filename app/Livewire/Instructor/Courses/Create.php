<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.instructor')]
class Create extends Component
{
    use WithFileUploads;

    public string $title = '';

    public ?string $description = '';

    public $price = 0;


    public bool $is_published = false;

    public ?TemporaryUploadedFile $thumbnail = null;

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($this->thumbnail) {
            $validated['thumbnail'] = $this->thumbnail->store('courses', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['is_published'] = false;

        $course = Course::create($validated);

        Toaster::success('Course berhasil dibuat.');

        $this->redirectRoute('instructor.courses.edit', $course, navigate: true);
    }

    public function render()
    {
        return view('livewire.instructor.courses.create');
    }
}
