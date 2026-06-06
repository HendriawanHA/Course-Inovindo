<?php

use App\Models\Course;
use App\Models\Discussion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;

it('counts active and completed enrollments on the instructor dashboard', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $studentOne = User::factory()->create(['role' => 'student']);
    $studentTwo = User::factory()->create(['role' => 'student']);
    $course = Course::create([
        'title' => 'Course Dashboard',
        'description' => 'Course untuk dashboard.',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);

    Enrollment::create([
        'user_id' => $studentOne->id,
        'course_id' => $course->id,
        'status' => 'active',
        'progress' => 20,
        'enrolled_at' => now(),
    ]);
    Enrollment::create([
        'user_id' => $studentTwo->id,
        'course_id' => $course->id,
        'status' => 'completed',
        'progress' => 100,
        'enrolled_at' => now(),
        'completed_at' => now(),
    ]);

    $this->actingAs($instructor)
        ->get(route('instructor.dashboard'))
        ->assertOk()
        ->assertSeeInOrder(['Students', '2']);
});

it('shows unanswered discussion count on the instructor dashboard', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $course = Course::create([
        'title' => 'Course Diskusi Dashboard',
        'description' => 'Course untuk diskusi.',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);
    $module = Module::create([
        'course_id' => $course->id,
        'title' => 'Module Diskusi',
        'order' => 1,
        'is_published' => true,
    ]);
    $lesson = Lesson::create([
        'module_id' => $module->id,
        'title' => 'Lesson Diskusi',
        'order' => 1,
        'is_preview' => false,
    ]);

    Discussion::create([
        'course_id' => $course->id,
        'lesson_id' => $lesson->id,
        'user_id' => $student->id,
        'content' => 'Pertanyaan student.',
    ]);

    $this->actingAs($instructor)
        ->get(route('instructor.dashboard'))
        ->assertOk()
        ->assertSee('1 diskusi belum dibalas');
});
