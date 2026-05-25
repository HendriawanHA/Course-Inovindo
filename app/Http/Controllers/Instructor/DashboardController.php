<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Discussion;

class DashboardController extends Controller
{
    public function index()
    {
        $courses = Course::where('user_id', auth()->id())->get();

        $discussionCount = Discussion::whereIn('course_id', $courses->pluck('id'))->count();

        return view('instructor.dashboard', compact('courses', 'discussionCount'));
    }
}
