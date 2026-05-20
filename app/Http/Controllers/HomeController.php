<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Recent Members
        $members = User::where('role', 'student')
            ->latest()
            ->take(3)
            ->get();

        // Total Students
        $totalStudents = User::where('role', 'student')
            ->count();

        // Total Courses
        $totalCourses = Course::count();

        // Featured Courses
        $featuredCourses = Course::latest()
            ->take(4)
            ->get();

        // Latest Events
        $latestEvents = Event::latest()
            ->take(3)
            ->get();

        // Top Students (sementara dummy pakai latest)
        $topStudents = User::where('role', 'student')
            ->orderByDesc('points')
            ->take(5)
            ->get();

        return view('livewire.pages.courses.home', compact(
            'members',
            'totalStudents',
            'totalCourses',
            'featuredCourses',
            'latestEvents',
            'topStudents'
        ));
    }
}
