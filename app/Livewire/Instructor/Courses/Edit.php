<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Models\Module;
use App\Models\Lesson;
use Masmerise\Toaster\Toaster;

#[Layout('components.layouts.instructor')]
class Edit extends Component
{
    use WithFileUploads;

    public Course $course;

    public string $title = '';

    public ?string $description = '';

    public $price = 0;

    public bool $is_published = false;
    public string $moduleTitle = '';

    public array $lessonTitles = [];
    public array $lessonVideoUrls = [];

    public ?TemporaryUploadedFile $thumbnail = null;

    public function mount(Course $course): void
    {
        abort_unless($course->user_id === auth()->id(), 403);

        $this->course = $course;

        $this->title = $course->title;
        $this->description = $course->description;
        $this->price = $course->price;
        $this->is_published = (bool) $course->is_published;
    }
    public function addModule(): void
    {
        $this->validate([
            'moduleTitle' => ['required', 'string', 'max:255'],
        ]);

        Module::create([
            'course_id' => $this->course->id,
            'title' => $this->moduleTitle,
            'order' => $this->course->modules()->count() + 1,
            'is_published' => true,
        ]);

        $this->moduleTitle = '';

        $this->course->refresh();
    }

    public function deleteModule(int $moduleId): void
    {
        $module = Module::where('id', $moduleId)
            ->where('course_id', $this->course->id)
            ->firstOrFail();

        $module->lessons()->delete();
        $module->delete();

        $this->course->refresh();
    }

    public function addLesson(int $moduleId): void
    {
        $title = trim($this->lessonTitles[$moduleId] ?? '');
        $videoUrl = trim($this->lessonVideoUrls[$moduleId] ?? '');

        if ($title === '') {
            $this->addError("lessonTitles.$moduleId", 'Judul lesson wajib diisi.');
            return;
        }

        $module = Module::where('id', $moduleId)
            ->where('course_id', $this->course->id)
            ->firstOrFail();

        Lesson::create([
            'module_id' => $module->id,
            'title' => $title,
            'video_url' => $videoUrl ?: null,
            'order' => $module->lessons()->count() + 1,
            'is_preview' => false,
        ]);

        $this->lessonTitles[$moduleId] = '';
        $this->lessonVideoUrls[$moduleId] = '';

        $this->course->refresh();
    }

    public function deleteLesson(int $lessonId): void
    {
        $lesson = Lesson::where('id', $lessonId)
            ->whereHas('module', function ($query) {
                $query->where('course_id', $this->course->id);
            })
            ->firstOrFail();

        $lesson->delete();

        $this->course->refresh();
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($this->thumbnail) {
            $validated['thumbnail'] = $this->thumbnail->store('courses', 'public');
        }

        $validated['is_published'] = $this->is_published;

        $this->course->update($validated);

        Toaster::success('Course berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.instructor.courses.edit', [
            'modules' => $this->course
                ->modules()
                ->with('lessons')
                ->orderBy('order')
                ->get(),
        ]);
    }
}
