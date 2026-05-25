<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/courses', [CourseController::class, 'index'])
    ->name('courses.index');

Route::get('/my-courses', [CourseController::class, 'myCourses'])
    ->middleware(['auth'])
    ->name('courses.my');

Route::get('/courses/{id}', [CourseController::class, 'show'])
    ->name('courses.show');

Route::get('/courses/{course}/lessons/{lesson}', [CourseController::class, 'video'])
    ->name('courses.video');

Route::post(
    '/courses/{course}/lessons/{lesson}/complete',
    [CourseController::class, 'completeLesson'])
    ->middleware('auth')
    ->name('lessons.complete');

Route::get('/events', [EventController::class, 'index'])
    ->name('events.index');

Route::get('/events/{slug}', [EventController::class, 'show'])
    ->name('events.show');

Route::get('/leaderboard', [LeaderboardController::class, 'index'])
    ->name('leaderboard.index');

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

require __DIR__ . '/auth.php';
