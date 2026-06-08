<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Masmerise\Toaster\Toaster;

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
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published');
        Course::create($validated);

        Toaster::success('Course berhasil dibuat.');

        return redirect()->route('instructor.courses.index');
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

        Toaster::success('Course berhasil diperbarui.');

        return redirect()->route('instructor.courses.index');
    }

    public function destroy(Course $course)
    {
        $this->authorizeCourse($course);

        $course->delete();

        Toaster::success('Course berhasil dihapus.');

        return redirect()->route('instructor.courses.index');
    }

    private function authorizeCourse(Course $course): void
    {
        abort_unless($course->user_id === auth()->id(), 403);
    }
}
