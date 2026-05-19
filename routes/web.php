<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/login', 'welcome');

Route::view('home', 'livewire.pages.courses.home')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/courses', [CourseController::class, 'index'])
    ->name('courses.index');

Route::get('/courses/{id}', [CourseController::class, 'show'])
    ->name('courses.show');

Route::get('/courses/{course}/lessons/{lesson}', [CourseController::class, 'video'])
    ->name('courses.video');

Route::get('/events', [EventController::class, 'index'])
    ->name('events.index');

Route::get('/events/{slug}', [EventController::class, 'show'])
    ->name('events.show');

route::get('/leaderboard', [LeaderboardController::class, 'index'])
    ->name('leaderboard.index');

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

require __DIR__ . '/auth.php';
