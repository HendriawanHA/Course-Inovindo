<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
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
            Course::withCount('enrollments')
                ->orderByDesc('enrollments_count')
                ->take(5)
                ->get()
        );

        View::composer('components.layouts.instructor', function ($view) {
            if (!Auth::check()) {
                return;
            }

            $courseIds = Course::where('user_id', Auth::id())->pluck('id');

            $unreadDiscussions = Discussion::whereIn('course_id', $courseIds)
                ->whereDoesntHave('replies', fn($q) => $q->whereRelation('user', 'role', 'instructor'))
                ->count();

            $unreadNotifications = Auth::user()->unreadNotifications->count();

            $sidebarCourses = Course::where('user_id', Auth::id())
                ->withCount('discussions')
                ->latest()
                ->take(10)
                ->get();

            $view->with(compact('unreadDiscussions', 'unreadNotifications', 'sidebarCourses'));
        });
    }
}
