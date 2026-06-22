<?php

namespace App\Livewire\Instructor\Courses;

use App\Filament\Resources\Courses\CourseResource;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewCourseNotification;
use App\Support\AdminNotification;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Masmerise\Toaster\Toaster;

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
        $students = User::where('role', 'student')->get();

        foreach ($students as $student) {
            $student->notify(
                new NewCourseNotification($course)
            );
        }


        $students = User::where('role', 'student')->get();
        foreach ($students as $student) {
            $student->notify(new NewCourseNotification($course));
        }

        AdminNotification::send(
            Notification::make()
                ->title('Course baru dibuat oleh instructor')
                ->body(Auth::user()->name . ' membuat course "' . $course->title . '".')
                ->icon('heroicon-o-book-open')
                ->iconColor('info')
                ->actions([
                    Action::make('view')
                        ->label('Lihat course')
                        ->url(CourseResource::getUrl('index')),
                ])
        );

        Toaster::success('Course berhasil dibuat.');

        $this->redirectRoute('instructor.courses.edit', $course, navigate: true);
    }

    public function render()
    {
        return view('livewire.instructor.courses.create');
    }
}
