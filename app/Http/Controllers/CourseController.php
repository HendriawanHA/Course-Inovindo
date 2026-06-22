<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Discussion;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\PointHistory;

class CourseController extends Controller
{


    public function index()
    {
        $search = request('search');
        $courses = Course::query()
            ->with([
                'enrollments' => function ($query) {
                    $query->where('user_id', auth()->id());
                },
                'modules',
                'lessons',
                'instructor',
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
            compact(
                'courses',
                'search'
            )
        );
    }

    public function show($id)
    {
        $course = Course::with('modules.lessons')->findOrFail($id);
        $user = auth()->user();

        if (
            $course->price > 0 &&
            ! $user->hasPurchasedCourse($course->id)
        ) {
            return redirect()
                ->route('courses.index')
                ->with('error', 'You need to purchase this course first.');
        }

        $enrollment = $this->getEnrollment($user, $course);
        $completedLessonIds = $this->getCompletedLessonIds($user, $course);

        $stats = $this->calculateProgress($course, $completedLessonIds);
        $navigation = $this->getNavigation($course, $user);

        $modules = $course->modules->map(function ($module) use ($completedLessonIds) {

            $module->total_lessons = $module->lessons->count();

            $module->lessons = $module->lessons->map(function ($lesson) use ($completedLessonIds) {

                $lesson->is_completed = in_array($lesson->id, $completedLessonIds);

                return $lesson;
            });

            return $module;
        });

        return view('livewire.pages.courses.detail-page', array_merge(
            compact('course', 'enrollment', 'completedLessonIds', 'modules'),
            $stats,
            $navigation
        ));
    }

    private function getEnrollment($user, $course)
    {
        return $user->enrollments()
            ->where('course_id', $course->id)
            ->first();
    }

    private function getCompletedLessonIds($user, $course)
    {
        return $user->completedLessons()
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->pluck('lesson_id')
            ->toArray();
    }

    private function calculateProgress($course, $completedLessonIds)
    {
        $totalLessons = $course->lessons()->count();
        $completedLessons = count($completedLessonIds);

        return [
            'totalLessons' => $totalLessons,
            'completedLessons' => $completedLessons,
            'progress' => $totalLessons > 0
                ? round(($completedLessons / $totalLessons) * 100)
                : 0,
            'hasStarted' => $completedLessons > 0,
            'isCompleted' => $totalLessons > 0 && $completedLessons >= $totalLessons,
        ];
    }

    private function getNavigation($course, $user)
    {
        $firstLesson = $course->firstLesson();
        $nextLesson = $course->getNextLessonForUser($user);

        return [
            'firstLesson' => $firstLesson,
            'nextLesson' => $nextLesson,
            'targetLesson' => $nextLesson ?? $firstLesson,
        ];
    }

    public function savedCourses()
    {
        $courses = auth()->user()
            ->bookmarkedCourses()
            ->with([
                'modules',
                'lessons',
                'instructor',
                'enrollments' => function ($query) {
                    $query->where('user_id', auth()->id());
                }
            ])
            ->latest()
            ->get();

        return view(
            'livewire.pages.courses.saved-course',
            compact(
                'courses'
            )
        );
    }

    public function myCourses()
    {
        $search = request('search');
        $courses = Course::query()
            ->whereHas('enrollments', function ($query) {
                $query->where(
                    'user_id',
                    auth()->id()
                );
            })
            ->when($search, function ($query) use ($search) {
                $query->where(
                    'title',
                    'like',
                    '%' . $search . '%'
                );
            })
            ->with([
                'enrollments' => function ($query) {
                    $query->where(
                        'user_id',
                        auth()->id()
                    );
                },
                'modules',
                'lessons',
                'instructor',
            ])
            ->latest()
            ->get();

        return view(
            'livewire.pages.courses.page-course',
            compact(
                'courses',
                'search'
            )
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

        $isPaidCourse = $course->price > 0;
        $lessonReward = $isPaidCourse ? 3 : 1;
        $moduleReward = $isPaidCourse ? 15 : 5;
        $courseReward = $isPaidCourse ? 50 : 20;

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
            LessonCompletion::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'completed_at' => now(),
            ]);
            $user->increment('points', $lessonReward);

            PointHistory::create([
                'user_id' => $user->id,
                'points' => $lessonReward,
                'source' => 'lesson',
            ]);
        }

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
            $user->increment('points', $moduleReward);

            PointHistory::create([
                'user_id' => $user->id,
                'points' => $moduleReward,
                'source' => 'module',
            ]);
            session()->put(
                'module_reward_' . $module->id . '_' . $user->id,
                true
            );
        }

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

        if ($courseCompletedNow) {
            $user->increment('points', $courseReward);

            PointHistory::create([
                'user_id' => $user->id,
                'points' => $courseReward,
                'source' => 'course',
            ]);
        }
        $user->level = floor($user->points / 100) + 1;
        $user->save();
        return back();
    }

    public function video($courseId, $lessonId)
    {
        $course = Course::with('modules.lessons')->findOrFail($courseId);
        $lesson = Lesson::findOrFail($lessonId);

        $enrollment = $this->ensureEnrollment($course);

        $lessons = $course->lessons->values();
        $currentIndex = $lessons->search(fn($l) => $l->id === $lesson->id);

        $previousLesson = $lessons[$currentIndex - 1] ?? null;
        $nextLesson = $lessons[$currentIndex + 1] ?? null;
        $totalLessons = $lessons->count();

        $completedIds = auth()->user()
            ->completedLessons()
            ->whereIn('lesson_id', $lessons->pluck('id'))
            ->pluck('lesson_id')
            ->toArray();

        $modules = $course->modules->map(function ($module) use ($completedIds) {
            $module->lessons = $module->lessons->map(function ($lesson) use ($completedIds) {
                $lesson->is_completed = in_array($lesson->id, $completedIds);
                return $lesson;
            });

            return $module;
        });

        $discussions = Discussion::with(['user', 'replies.user'])
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->latest()
            ->get();

        return view('livewire.pages.courses.video-course', [
            'course' => $course,
            'lesson' => $lesson,
            'modules' => $modules,
            'currentIndex' => $currentIndex,
            'totalLessons' => $totalLessons,
            'previousLesson' => $previousLesson,
            'nextLesson' => $nextLesson,
            'discussions' => $discussions,
        ]);
    }

    private function ensureEnrollment($course)
    {
        return Enrollment::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
        ], [
            'status' => 'active',
            'progress' => 0,
            'enrolled_at' => now(),
        ]);
    }

    private function resolveNavigation($lessons, $currentLesson)
    {
        $index = $lessons->search(fn($l) => $l->id === $currentLesson->id);

        return [
            $lessons[$index - 1] ?? null,
            $lessons[$index + 1] ?? null,
            $index
        ];
    }

    private function getDiscussions($course, $lesson)
    {
        return Discussion::with(['user', 'replies.user'])
            ->where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->latest()
            ->get();
    }
}
