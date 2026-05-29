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

        $members = User::where('role', 'student')->latest()->take(3)->get();
        $totalStudents = User::where('role', 'student')->count();
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | USER RANK SYSTEM
        |--------------------------------------------------------------------------
        */

        $ranks = [
            ['name' => 'Newbie', 'points' => 0],
            ['name' => 'Explorer', 'points' => 50],
            ['name' => 'Contributor', 'points' => 150],
            ['name' => 'Player', 'points' => 300],
            ['name' => 'Builder', 'points' => 600],
            ['name' => 'Catalyst', 'points' => 1000],
            ['name' => 'Operator', 'points' => 1500],
            ['name' => 'Pro', 'points' => 2500],
            ['name' => 'Legend', 'points' => 4000],
        ];

        $currentRank = collect($ranks)
            ->filter(function ($rank) use ($user) {
                return $user->points >= $rank['points'];
            })
            ->last();

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

        $members = User::where('role', 'student')
            ->latest()
            ->take(3)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | FEATURED COURSES
        |--------------------------------------------------------------------------
        */

        $featuredCourses = Course::latest()
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

        $topStudents = User::where('role', 'student')
            ->orderByDesc('points')
            ->take(5)
            ->get();

        return view('livewire.pages.courses.home', compact(
            'members',
            'featuredCourses',
            'latestEvents',
            'topStudents',
            'totalStudents',

            // USER STATS
            'currentRank',
            'myCourses',
            'completedCourses'
        ));
    }
}
