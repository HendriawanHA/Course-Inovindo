<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $search = request('search');

        $courses = Course::query()

            ->when($search, function ($query) use ($search) {

                $query->where('title', 'like', '%' . $search . '%');
            })

            ->latest()
            ->get();

        return view(
            'livewire.pages.courses.page-course',
            compact('courses', 'search')
        );
    }

    public function show($id)
    {
        $course = Course::with('modules.lessons')->findOrFail($id);
        return view('livewire.pages.courses.detail-page', compact('course', 'id'));
    }

    public function myCourses()
    {
        $course = collect();

        return view('livewire.pages.courses.my-course', [
            'courses' => $course,
        ]);
    }

    public function video($courseId, $lessonId)
    {
        $course = Course::with('modules.lessons')
            ->findOrFail($courseId);

        $lesson = \App\Models\Lesson::with('module.lessons')
            ->findOrFail($lessonId);

        $currentModule = $lesson->module;

        $moduleLessons = $currentModule->lessons;

        $currentIndex = $moduleLessons
            ->search(fn($item) => $item->id === $lesson->id);

        $previousLesson = $moduleLessons[$currentIndex - 1] ?? null;

        $nextLesson = $moduleLessons[$currentIndex + 1] ?? null;

        $currentLessonIndex = $moduleLessons
            ->search(fn($item) => $item->id === $lesson->id);

        $totalLessons = $moduleLessons->count();

        $discussions = \App\Models\Discussion::with('user')
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->latest()
            ->get();
        $discussions = Discussion::with(['user', 'replies.user'])
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->latest()
            ->get();

        return view(
            'livewire.pages.courses.video-course',
            compact(
                'course',
                'lesson',
                'currentLessonIndex',
                'totalLessons',
                'previousLesson',
                'nextLesson',
                'discussions'
            )
        );
    }
}
