<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Event;
use App\Models\User;
use App\Models\Enrollment;

class HomeController extends Controller
{
    public function index()
    {
        $totalStudents = User::students()->count();
        $user = auth()->user();

        $myCourses = Enrollment::where('user_id', $user->id)
            ->count();

        $completedCourses = Enrollment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $members = User::students()
            ->latest()
            ->take(3)
            ->get();

        $topCourses = Course::popular()
            ->with('modules', 'lessons', 'instructor')
            ->take(4)
            ->get();

        $latestEvents = Event::latest()
            ->take(3)
            ->get();

        $topStudents = User::topStudents()
            ->take(5)
            ->get();

        return view('livewire.pages.courses.home', compact(
            'user',
            'members',
            'topCourses',
            'latestEvents',
            'topStudents',
            'totalStudents',

            // USER STATS
            'myCourses',
            'completedCourses'
        ));
    }
}
