<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Instructor\DiscussionController as InstructorDiscussionController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Livewire\Instructor\Courses\Create as InstructorCoursesCreate;
use App\Livewire\Instructor\Courses\Edit as InstructorCoursesEdit;
use App\Livewire\Instructor\Courses\Index as InstructorCoursesIndex;
use App\Livewire\Instructor\Courses\Preview as InstructorCoursesPreview;
use App\Livewire\Instructor\Profile as InstructorProfile;
use App\Livewire\Instructor\Students\Index as InstructorStudentsIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'student'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::view('/profile', 'profile')->name('profile');

    // Courses
    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('my');
        Route::get('/saved-courses', [CourseController::class, 'savedCourses'])->name('saved');
        Route::get('/{id}', [CourseController::class, 'show'])->name('show');
        Route::get('/{course}/lessons/{lesson}', [CourseController::class, 'video'])->name('video');
        Route::post('/{course}/bookmark', [CourseController::class, 'toggleBookmark'])->name('bookmark');
    });

    Route::post(
        '/courses/{course}/lessons/{lesson}/complete',
        [CourseController::class, 'completeLesson']
    )->name('lessons.complete');

    // Events
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/{slug}', [EventController::class, 'show'])->name('show');
    });

    // Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    // Discussions
    Route::prefix('discussions')->name('discussions.')->group(function () {
        Route::post('/', [DiscussionController::class, 'store'])->name('store');
        Route::post('/{discussion}/reply', [DiscussionController::class, 'reply'])->name('reply');
    });

    Route::post(
        '/courses/{course}/buy',
        [TransactionController::class, 'buy']
    )->name('courses.buy');

    Route::get(
        '/notifications/{notification}',
        [NotificationController::class, 'read']
    )->name('notifications.read');
});

Route::prefix('certificates')->name('certificates.')->group(function () {

    Route::get('/{course}', [CertificateController::class, 'show'])
        ->name('show');

    Route::get('/{course}/download', [CertificateController::class, 'download'])
        ->name('download');
});

/*
|--------------------------------------------------------------------------
| INSTRUCTOR ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'instructor'])->prefix('instructor')->name('instructor.')->group(function () {

    Route::get('/', [InstructorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', InstructorProfile::class)->name('profile');

    // Courses
    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', InstructorCoursesIndex::class)->name('index');
        Route::get('/create', InstructorCoursesCreate::class)->name('create');
        Route::get('/{course}/edit', InstructorCoursesEdit::class)->name('edit');
        Route::get('/{course}/preview', InstructorCoursesPreview::class)->name('preview');
    });

    // Discussions
    Route::prefix('discussions')->name('discussions.')->group(function () {
        Route::get('/', [InstructorDiscussionController::class, 'index'])->name('index');
        Route::post('/{discussion}/reply', [InstructorDiscussionController::class, 'reply'])->name('reply');
    });

    // Students
    Route::get('/students', InstructorStudentsIndex::class)->name('students.index');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION & REDIRECTS
|--------------------------------------------------------------------------
*/
Route::get('/redirect-after-login', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        'admin'      => redirect('/admin'),
        'instructor' => redirect()->route('instructor.dashboard'),
        default      => redirect()->route('home'),
    };
})->middleware('auth')->name('redirect.after.login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

require __DIR__ . '/auth.php';
