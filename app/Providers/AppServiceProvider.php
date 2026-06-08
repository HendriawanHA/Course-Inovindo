<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Carbon\Carbon::setLocale('id');

        View::share(
            'topCourses',
            Schema::hasTable('courses')
                ? Course::withCount('enrollments')
                    ->with('modules', 'lessons', 'instructor')
                    ->orderByDesc('enrollments_count')
                    ->take(5)
                    ->get()
                : collect()
        );

        View::composer('components.layouts.instructor', function ($view) {
            if (!Auth::check()) {
                return;
            }

            if (!Schema::hasTable('courses')) {
                $unreadDiscussions = 0;
                $sidebarCourses = collect();

                $view->with(compact('unreadDiscussions', 'sidebarCourses'));

                return;
            }

            $sidebarCourses = Course::where('user_id', Auth::id())
                ->withCount('discussions')
                ->withMax('discussions', 'created_at')
                ->latest()
                ->take(10)
                ->get()
                ->map(function (Course $course) {
                    $viewedAt = session("instructor.discussions.viewed_at.{$course->id}");
                    $latestDiscussionAt = $course->discussions_max_created_at;

                    $course->setAttribute(
                        'has_unread_discussions',
                        $latestDiscussionAt && (! $viewedAt || $latestDiscussionAt > $viewedAt)
                    );

                    return $course;
                });

            $unreadDiscussions = $sidebarCourses->where('has_unread_discussions', true)->count();

            $view->with(compact('unreadDiscussions', 'sidebarCourses'));
        });
    }
}
