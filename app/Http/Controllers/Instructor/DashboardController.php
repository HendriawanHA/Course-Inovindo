<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Enrollment;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $courseIds = Course::where('user_id', auth()->id())->pluck('id');

        $courses = Course::where('user_id', auth()->id())
            ->withCount('enrollments')
            ->withCount('discussions')
            ->withCount([
                'discussions as unanswered_discussions_count' => fn($query) => $query
                    ->whereDoesntHave('replies', fn($replyQuery) => $replyQuery->whereRelation('user', 'role', 'instructor')),
            ])
            ->latest()
            ->get();

        $totalCourses = $courses->count();
        $totalStudents = Enrollment::whereIn('course_id', $courseIds)
 ->where('status', 'paid')
            ->distinct('user_id')
            ->count('user_id');

        $totalRevenue = Transaction::whereIn('course_id', $courseIds)
            ->where('status', 'paid')
            ->sum('amount');

        $totalDiscussions = Discussion::whereIn('course_id', $courseIds)->count();

        $totalUnansweredDiscussions = Discussion::whereIn('course_id', $courseIds)
            ->whereDoesntHave('replies', fn($query) => $query->whereRelation('user', 'role', 'instructor'))
            ->count();

        $totalEnrollments = Enrollment::whereIn('course_id', $courseIds)->count();
        $completedEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->where('status', 'completed')
            ->count();
        $completionRate = $totalEnrollments > 0
            ? round(($completedEnrollments / $totalEnrollments) * 100)
            : 0;

        $recentEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        $totalLessons = DB::table('lessons')
            ->join('modules', 'lessons.module_id', '=', 'modules.id')
            ->whereIn('modules.course_id', $courseIds)
            ->count();

        return view('instructor.dashboard', compact(
            'courses',
            'totalCourses',
            'totalStudents',
            'totalRevenue',
            'totalDiscussions',
            'totalUnansweredDiscussions',
            'completionRate',
            'recentEnrollments',
            'totalLessons',
        ));
    }
}
