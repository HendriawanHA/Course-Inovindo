<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Event;
use App\Models\User;

class LandingPageController extends Controller
{
    public function index()
    {
        $courses = Course::query()
            ->withCount([
                'enrollments',
                'modules',
            ])
            ->with('modules.lessons')
            ->where('is_published', true)
            ->orderByDesc('enrollments_count')
            ->take(3)
            ->get()
            ->map(function ($course) {

                $course->lessons_count =
                    $course->modules->sum(
                        fn($module) => $module->lessons->count()
                    );

                return $course;
            });

        $events = Event::query()
            ->latest()
            ->take(3)
            ->get();

        // Statistik
        $coursesCount = Course::where('is_published', true)->count();

        $studentsCount = User::where('role', 'student')->count();

        $eventsCount = Event::count();

        return view('landing', compact(
            'courses',
            'events',
            'coursesCount',
            'studentsCount',
            'eventsCount'
        ));
    }
}
