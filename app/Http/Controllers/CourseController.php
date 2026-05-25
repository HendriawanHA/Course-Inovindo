<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Discussion;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonCompletion;

class CourseController extends Controller
{
    public function index()
    {
        $search = request('search');

        $courses = Course::query()

            ->with([
                'enrollments' => function ($query) {
                    $query->where('user_id', auth()->id());
                }
            ])

            ->when($search, function ($query) use ($search) {

                $query->where(
                    'title',
                    'like',
                    '%' . $search . '%'
                );
            })

            ->latest()
            ->get();

        return view(
            'livewire.pages.courses.page-course',
            compact('courses', 'search')
        );
    }

    public function show($id)
    {
        $course = Course::with('modules.lessons')
            ->findOrFail($id);

        $enrollment = auth()->user()
            ->enrollments()
            ->where('course_id', $course->id)
            ->first();

        return view(
            'livewire.pages.courses.detail-page',
            compact('course', 'enrollment')
        );
    }

    public function savedCourses()
    {
        $courses = auth()->user()
            ->bookmarkedCourses()
            ->with([
                'modules.lessons',
                'enrollments' => function ($query) {
                    $query->where('user_id', auth()->id());
                }
            ])
            ->latest()
            ->get();

        return view(
            'livewire.pages.courses.saved-course',
            compact('courses')
        );
    }

    public function toggleBookmark(Course $course)
    {
        $user = auth()->user();

        if (
            $user->bookmarkedCourses()
            ->where('course_id', $course->id)
            ->exists()
        ) {

            $user->bookmarkedCourses()
                ->detach($course->id);
        } else {

            $user->bookmarkedCourses()
                ->attach($course->id);
        }

        return back();
    }

    public function completeLesson($courseId, $lessonId)
    {
        $user = auth()->user();

        $course = Course::with('modules.lessons')
            ->findOrFail($courseId);

        $lesson = Lesson::findOrFail($lessonId);

        /*
    |--------------------------------------------------------------------------
    | CEK apakah lesson sudah selesai sebelumnya
    |--------------------------------------------------------------------------
    */

        $alreadyCompleted = LessonCompletion::where(
            'user_id',
            $user->id
        )
            ->where(
                'lesson_id',
                $lesson->id
            )
            ->exists();

        if (!$alreadyCompleted) {

            /*
        |--------------------------------------------------------------------------
        | Simpan lesson completion
        |--------------------------------------------------------------------------
        */

            LessonCompletion::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'completed_at' => now(),
            ]);

            /*
        |--------------------------------------------------------------------------
        | LESSON REWARD
        |--------------------------------------------------------------------------
        */

            $user->increment('points', 10);
        }

        /*
    |--------------------------------------------------------------------------
    | MODULE COMPLETE CHECK
    |--------------------------------------------------------------------------
    */

        $module = $lesson->module;

        $moduleLessonIds = $module->lessons->pluck('id');

        $completedInModule = LessonCompletion::where(
            'user_id',
            $user->id
        )
            ->whereIn('lesson_id', $moduleLessonIds)
            ->count();

        $moduleAlreadyCompleted =
            session()->has(
                'module_reward_' . $module->id . '_' . $user->id
            );

        if (
            $completedInModule === $module->lessons->count()
            && !$moduleAlreadyCompleted
        ) {

            $user->increment('points', 50);

            session()->put(
                'module_reward_' . $module->id . '_' . $user->id,
                true
            );
        }

        /*
    |--------------------------------------------------------------------------
    | COURSE COMPLETE CHECK
    |--------------------------------------------------------------------------
    */

        $totalLessons = $course->lessons()->count();

        $completedLessons = LessonCompletion::where(
            'user_id',
            $user->id
        )
            ->whereIn(
                'lesson_id',
                $course->lessons->pluck('id')
            )
            ->count();

        $progress = round(
            ($completedLessons / $totalLessons) * 100
        );

        /*
    |--------------------------------------------------------------------------
    | Enrollment
    |--------------------------------------------------------------------------
    */

        $enrollment = Enrollment::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ], [
            'status' => 'active',
            'progress' => 0,
            'enrolled_at' => now(),
        ]);

        $courseCompletedNow = false;

        if (
            $progress >= 100
            && $enrollment->status !== 'completed'
        ) {

            $courseCompletedNow = true;

            $enrollment->update([
                'status' => 'completed',
                'progress' => 100,
                'completed_at' => now(),
            ]);
        } else {

            $enrollment->update([
                'progress' => $progress,
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | COURSE REWARD
    |--------------------------------------------------------------------------
    */

        if ($courseCompletedNow) {

            $user->increment('points', 200);
        }

        /*
    |--------------------------------------------------------------------------
    | LEVEL SYSTEM
    |--------------------------------------------------------------------------
    */

        $user->level = floor($user->points / 100) + 1;

        $user->save();

        return back();
    }

    public function video($courseId, $lessonId)
    {
        $course = Course::with('modules.lessons')
            ->findOrFail($courseId);

        $lesson = Lesson::with('module.lessons')
            ->findOrFail($lessonId);

        /*
    |--------------------------------------------------------------------------
    | Auto Enrollment
    |--------------------------------------------------------------------------
    */

        Enrollment::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
        ], [
            'status' => 'active',
            'progress' => 0,
            'enrolled_at' => now(),
        ]);

        /*
    |--------------------------------------------------------------------------
    | Navigation Lesson
    |--------------------------------------------------------------------------
    */

        $allLessons = $course->lessons()->get();

        $currentLessonIndex = $allLessons
            ->search(fn($item) => $item->id === $lesson->id);

        $previousLesson = $allLessons[$currentLessonIndex - 1] ?? null;

        $nextLesson = $allLessons[$currentLessonIndex + 1] ?? null;

        $totalLessons = $allLessons->count();

        $discussions = \App\Models\Discussion::with('user')
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->latest()
            ->get();
        $discussions = Discussion::with(['user', 'replies.user'])
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->latest()
            ->get();

        return view(
            'livewire.pages.courses.video-course',
            compact(
                'course',
                'lesson',
                'currentLessonIndex',
                'totalLessons',
                'previousLesson',
                'nextLesson',
                'discussions'
            )
        );
    }
}
