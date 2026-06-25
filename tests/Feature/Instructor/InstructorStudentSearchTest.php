<?php

use App\Livewire\Instructor\Students\Index as StudentIndex;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Livewire\Livewire;

it('searches students by name, email, or course title', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create([
        'role' => 'student',
        'name' => 'Andi Searchable',
        'email' => 'andi-searchable@example.com',
    ]);
    $course = Course::create([
        'title' => 'Course Search Student',
        'description' => 'Course untuk search student.',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);

    Enrollment::create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'active',
        'progress' => 10,
        'enrolled_at' => now(),
    ]);

    $this->actingAs($instructor);

    Livewire::test(StudentIndex::class)
        ->set('search', 'Andi')
        ->assertSee('Andi Searchable')
        ->set('search', 'andi-searchable@example.com')
        ->assertSee('Andi Searchable')
        ->set('search', 'Course Search Student')
        ->assertSee('Andi Searchable');
});

it('does not show students from another instructors courses when searching', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create([
        'role' => 'student',
        'name' => 'Student Milik Instructor Lain',
    ]);
    $course = Course::create([
        'title' => 'Course Instructor Lain',
        'description' => 'Bukan milik instructor aktif.',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $otherInstructor->id,
    ]);

    Enrollment::create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'active',
        'progress' => 10,
        'enrolled_at' => now(),
    ]);

    $this->actingAs($instructor);

    Livewire::test(StudentIndex::class)
        ->set('search', 'Student Milik')
        ->assertDontSee('Student Milik Instructor Lain');
});

it('filters students by the selected course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Dipilih',
        'description' => 'Course filter aktif.',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);
    $otherCourse = Course::create([
        'title' => 'Course Lain',
        'description' => 'Course filter lain.',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);
    $student = User::factory()->create(['role' => 'student', 'name' => 'Student Course Dipilih']);
    $otherStudent = User::factory()->create(['role' => 'student', 'name' => 'Student Course Lain']);

    Enrollment::create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'active',
        'progress' => 10,
        'enrolled_at' => now(),
    ]);
    Enrollment::create([
        'user_id' => $otherStudent->id,
        'course_id' => $otherCourse->id,
        'status' => 'active',
        'progress' => 10,
        'enrolled_at' => now(),
    ]);

    $this->actingAs($instructor);

    Livewire::test(StudentIndex::class)
        ->set('courseId', (string) $course->id)
        ->assertSee('Student Course Dipilih')
        ->assertDontSee('Student Course Lain');
});

it('paginates students ten per page', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Banyak Student',
        'description' => 'Course untuk pagination.',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);

    foreach (range(1, 11) as $number) {
        $student = User::factory()->create([
            'role' => 'student',
            'name' => sprintf('Student Page %02d', $number),
        ]);

        Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress' => 10,
            'enrolled_at' => now(),
        ]);
    }

    $this->actingAs($instructor);

    Livewire::test(StudentIndex::class)
        ->assertViewHas('enrollments', fn($enrollments) => $enrollments->perPage() === 10 && $enrollments->total() === 11);
});
