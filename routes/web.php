<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Instructor\DiscussionController as InstructorDiscussionController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Livewire\Instructor\Courses\Index as InstructorCoursesIndex;
use App\Livewire\Instructor\Courses\Create as InstructorCoursesCreate;
use App\Livewire\Instructor\Courses\Edit as InstructorCoursesEdit;
use App\Livewire\Instructor\Courses\Preview as InstructorCoursesPreview;
use App\Livewire\Instructor\Students\Index as InstructorStudentsIndex;

/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'student'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    Route::view('/profile', 'profile')
        ->name('profile');

    Route::get('/courses', [CourseController::class, 'index'])
        ->name('courses.index');

    Route::get('/my-courses', [CourseController::class, 'myCourses'])
        ->name('courses.my');

    Route::get('/courses/{id}', [CourseController::class, 'show'])
        ->name('courses.show');

    Route::get('/courses/{course}/lessons/{lesson}', [CourseController::class, 'video'])
        ->name('courses.video');

    Route::get('/events', [EventController::class, 'index'])
        ->name('events.index');

    Route::get('/events/{slug}', [EventController::class, 'show'])
        ->name('events.show');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])
        ->name('leaderboard.index');

    Route::post('/discussions', [DiscussionController::class, 'store'])
        ->name('discussions.store');

    Route::post('/discussions/{discussion}/reply', [DiscussionController::class, 'reply'])
        ->name('discussions.reply');
});

/*
|--------------------------------------------------------------------------
| INSTRUCTOR ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'instructor'])
    ->prefix('instructor')
    ->name('instructor.')
    ->group(function () {
        Route::get('/courses', InstructorCoursesIndex::class)
            ->name('courses.index');
        Route::get('/courses', InstructorCoursesIndex::class)
            ->name('courses.index');
        Route::get('/courses/{course}/preview', InstructorCoursesPreview::class)
            ->name('courses.preview');

        Route::get('/courses/create', InstructorCoursesCreate::class)
            ->name('courses.create');

        Route::get('/courses/{course}/edit', InstructorCoursesEdit::class)
            ->name('courses.edit');

        Route::get('/', [InstructorDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/discussions', [InstructorDiscussionController::class, 'index'])
            ->name('discussions.index');

        Route::post('/discussions/{discussion}/reply', [InstructorDiscussionController::class, 'reply'])
            ->name('discussions.reply');

        Route::get('/students', InstructorStudentsIndex::class)
            ->name('students.index');
    });

/*
|--------------------------------------------------------------------------
| REDIRECT AFTER LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/redirect-after-login', function () {

    $user = auth()->user();

    if (! $user) {
        return redirect()->route('login');
    }

    if ($user->role === 'admin') {
        return redirect('/admin');
    }

    if ($user->role === 'instructor') {
        return redirect()->route('instructor.dashboard');
    }

    return redirect()->route('home');
})->middleware('auth')->name('redirect.after.login');

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

require __DIR__ . '/auth.php';
