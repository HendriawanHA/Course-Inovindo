<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Event;

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

        $events = Event::latest()
            ->take(3)
            ->get();

        return view('landing', compact(
            'courses',
            'events'
        ));
    }
}
