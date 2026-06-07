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
