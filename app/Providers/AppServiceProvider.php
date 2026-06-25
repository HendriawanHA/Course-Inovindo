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
                $sidebarCourses = collect();

                $view->with(compact('unreadDiscussions', 'sidebarCourses'));

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

    private function configureMidtrans(): void
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        if (app()->environment('local')) {
        \Midtrans\Config::$curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => [],
        ];
        }
    }
}
