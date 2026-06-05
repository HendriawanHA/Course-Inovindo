<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewCourseNotification;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('instructor.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('instructor.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('courses', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published');

        $course = Course::create($validated);

        $students = User::where('role', 'student')->get();

        foreach ($students as $student) {
            $student->notify(
                new NewCourseNotification($course)
            );
        }

        return redirect()
            ->route('instructor.courses.index')
            ->with('success', 'Course berhasil dibuat.');
    }

    public function show(Course $course)
    {
        $this->authorizeCourse($course);

        return view('instructor.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $this->authorizeCourse($course);

        return view('instructor.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeCourse($course);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->update($validated);

        return redirect()
            ->route('instructor.courses.index')
            ->with('success', 'Course berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        $this->authorizeCourse($course);

        $course->delete();

        return redirect()
            ->route('instructor.courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }

    private function authorizeCourse(Course $course): void
    {
        abort_unless($course->user_id === auth()->id(), 403);
    }
}
