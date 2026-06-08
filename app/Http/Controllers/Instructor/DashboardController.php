<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        $courseIds = Course::where('user_id', auth()->id())->pluck('id');

        $courses = Course::where('user_id', auth()->id())
            ->withCount([
                'discussions as unanswered_discussions_count' => fn($query) => $query
                    ->whereDoesntHave('replies', fn($replyQuery) => $replyQuery->whereRelation('user', 'role', 'instructor')),
            ])
            ->withCount('lessons')
            ->latest()
            ->get();

        $totalCourses = $courses->count();
        $dashboardCourses = $courses->take(5);

        $totalStudents = Enrollment::whereIn('course_id', $courseIds)
            ->whereIn('status', ['active', 'completed'])
            ->distinct('user_id')
            ->count('user_id');

        $totalUnansweredDiscussions = Discussion::whereIn('course_id', $courseIds)
            ->whereDoesntHave('replies', fn($query) => $query->whereRelation('user', 'role', 'instructor'))
            ->count();

        $recentEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        return view('instructor.dashboard', compact(
            'totalCourses',
            'totalStudents',
            'totalUnansweredDiscussions',
            'recentEnrollments',
            'dashboardCourses',
        ));
    }
}
