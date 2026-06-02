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

        /*
        |--------------------------------------------------------------------------
        | USER RANK SYSTEM
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | USER COURSES
        |--------------------------------------------------------------------------
        */

        $myCourses = Enrollment::where('user_id', $user->id)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | COMPLETED COURSES
        |--------------------------------------------------------------------------
        */

        $completedCourses = Enrollment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | RECENT MEMBERS
        |--------------------------------------------------------------------------
        */

        $members = User::students()
            ->latest()
            ->take(3)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | FEATURED COURSES
        |--------------------------------------------------------------------------
        */

        $topCourses = Course::popular()
            ->take(4)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | EVENTS
        |--------------------------------------------------------------------------
        */

        $latestEvents = Event::latest()
            ->take(3)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOP STUDENTS
        |--------------------------------------------------------------------------
        */

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
