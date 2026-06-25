<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Discussion;
use App\Models\Enrollment;
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

        View::composer('components.sidebar', function ($view) {

            $myCourses = collect();

            if (auth()->check()) {
                $myCourses = Enrollment::with('course')
                    ->where('user_id', auth()->id())
                    ->orderByDesc('progress')
                    ->take(5)
                    ->get();
            }

            $view->with('myCourses', $myCourses);
        });

        View::composer('components.layouts.instructor', function ($view) {
            if (!Auth::check()) {
                return;
            }

            if (!Schema::hasTable('courses')) {
                $unreadDiscussions = 0;
                $unreadNotifications = 0;
                $sidebarCourses = collect();

                $view->with(compact('unreadDiscussions', 'unreadNotifications', 'sidebarCourses'));

                return;
            }

            $courseIds = Course::where('user_id', Auth::id())->pluck('id');

            $unreadDiscussions = Schema::hasTable('discussions')
                ? Discussion::whereIn('course_id', $courseIds)
                ->whereDoesntHave('replies', fn($q) => $q->whereRelation('user', 'role', 'instructor'))
                ->count()
                : 0;

            $unreadNotifications = Schema::hasTable('notifications')
                ? Auth::user()->unreadNotifications->count()
                : 0;

            $sidebarCourses = Course::where('user_id', Auth::id())
                ->withCount('discussions')
                ->latest()
                ->take(10)
                ->get();

            $view->with(compact('unreadDiscussions', 'unreadNotifications', 'sidebarCourses'));
        });
    }
}
