<?php

use App\Livewire\Instructor\Courses\Create as CreateCourse;
use App\Livewire\Instructor\Courses\Edit as EditCourse;
use App\Livewire\Instructor\Courses\Index as CourseIndex;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Livewire\Livewire;

it('only shows courses owned by the authenticated instructor', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);

    Course::create([
        'title' => 'Course Milik Saya',
        'description' => 'Course sendiri.',
        'price' => 100000,
        'is_published' => false,
        'user_id' => $instructor->id,
    ]);

    Course::create([
        'title' => 'Course Milik Orang Lain',
        'description' => 'Course instructor lain.',
        'price' => 100000,
        'is_published' => false,
        'user_id' => $otherInstructor->id,
    ]);

    $this->actingAs($instructor);

    Livewire::test(CourseIndex::class)
        ->assertSee('Course Milik Saya')
        ->assertDontSee('Course Milik Orang Lain');
});

it('searches only courses owned by the authenticated instructor', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);

    Course::create([
        'title' => 'Laravel Search Course',
        'description' => 'Course milik instructor aktif.',
        'price' => 100000,
        'is_published' => false,
        'user_id' => $instructor->id,
    ]);

    Course::create([
        'title' => 'Laravel Search Course Other',
        'description' => 'Course milik instructor lain.',
        'price' => 100000,
        'is_published' => false,
        'user_id' => $otherInstructor->id,
    ]);

    $this->actingAs($instructor);

    Livewire::test(CourseIndex::class)
        ->set('search', 'Laravel Search')
        ->assertSee('Laravel Search Course')
        ->assertDontSee('Laravel Search Course Other');
});

it('persists the selected course view in the session', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    $this->actingAs($instructor);

    Livewire::test(CourseIndex::class)
        ->set('view', 'list')
        ->assertSet('view', 'list');

    expect(session('instructor.courses.view'))->toBe('list');

    Livewire::test(CourseIndex::class)
        ->assertSet('view', 'list');
});

it('paginates courses based on the selected view', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    foreach (range(1, 11) as $number) {
        Course::create([
            'title' => sprintf('Course Page %02d', $number),
            'description' => 'Course untuk pagination.',
            'price' => 100000,
            'is_published' => false,
            'user_id' => $instructor->id,
        ]);
    }

    $this->actingAs($instructor);

    Livewire::test(CourseIndex::class)
        ->assertViewHas('courses', fn($courses) => $courses->perPage() === 9 && $courses->total() === 11)
        ->set('view', 'list')
        ->assertViewHas('courses', fn($courses) => $courses->perPage() === 10 && $courses->total() === 11);
});

it('allows instructors to create a draft course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    $this->actingAs($instructor);

    Livewire::test(CreateCourse::class)
        ->set('title', 'Course Draft Instructor')
        ->set('description', 'Course dibuat oleh instructor.')
        ->set('price', 50000)
        ->call('save');

    $this->assertDatabaseHas('courses', [
        'title' => 'Course Draft Instructor',
        'user_id' => $instructor->id,
        'is_published' => false,
    ]);
});

it('requires a title when instructors create a course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    $this->actingAs($instructor);

    Livewire::test(CreateCourse::class)
        ->set('title', '')
        ->set('price', 50000)
        ->call('save')
        ->assertHasErrors(['title' => 'required']);
});

it('allows instructors to edit their own course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Sebelum Edit',
        'description' => 'Deskripsi lama.',
        'price' => 50000,
        'is_published' => false,
        'user_id' => $instructor->id,
    ]);

    $this->actingAs($instructor);

    Livewire::test(EditCourse::class, ['course' => $course])
        ->set('title', 'Course Setelah Edit')
        ->set('description', 'Deskripsi baru.')
        ->set('price', 75000)
        ->call('save')
        ->assertHasNoErrors();

    expect($course->refresh()->title)->toBe('Course Setelah Edit');
});

it('forbids instructors from editing another instructors course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Instruktur Lain',
        'description' => 'Tidak boleh diedit.',
        'price' => 50000,
        'is_published' => false,
        'user_id' => $otherInstructor->id,
    ]);

    $this->actingAs($instructor)
        ->get(route('instructor.courses.edit', $course))
        ->assertForbidden();
});

it('forbids instructors from previewing another instructors course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Preview Course Instruktur Lain',
        'description' => 'Tidak boleh dipreview.',
        'price' => 50000,
        'is_published' => false,
        'user_id' => $otherInstructor->id,
    ]);

    $this->actingAs($instructor)
        ->get(route('instructor.courses.preview', $course))
        ->assertForbidden();
});

it('allows instructors to add modules and lessons to their course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Builder',
        'description' => 'Course untuk module dan lesson.',
        'price' => 50000,
        'is_published' => false,
        'user_id' => $instructor->id,
    ]);

    $this->actingAs($instructor);

    $component = Livewire::test(EditCourse::class, ['course' => $course])
        ->set('moduleTitle', 'Module 1')
        ->call('addModule')
        ->assertHasNoErrors();

    $module = Module::where('course_id', $course->id)->firstOrFail();

    $component
        ->set("lessonTitles.{$module->id}", 'Lesson 1')
        ->set("lessonVideoUrls.{$module->id}", 'https://youtube.com/watch?v=abc123')
        ->call('addLesson', $module->id)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('lessons', [
        'module_id' => $module->id,
        'title' => 'Lesson 1',
    ]);
});

it('prevents publishing a course without a thumbnail', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Tanpa Thumbnail',
        'description' => 'Belum punya thumbnail.',
        'price' => 50000,
        'is_published' => false,
        'user_id' => $instructor->id,
    ]);

    $this->actingAs($instructor);

    Livewire::test(EditCourse::class, ['course' => $course])
        ->set('is_published', true)
        ->call('save')
        ->assertHasErrors(['thumbnail']);
});

it('prevents publishing a course without lessons', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Tanpa Lesson',
        'description' => 'Belum punya lesson.',
        'thumbnail' => 'courses/thumbnail.jpg',
        'price' => 50000,
        'is_published' => false,
        'user_id' => $instructor->id,
    ]);

    $this->actingAs($instructor);

    Livewire::test(EditCourse::class, ['course' => $course])
        ->set('is_published', true)
        ->call('save')
        ->assertHasErrors(['is_published']);
});

it('allows publishing a course with thumbnail and lessons', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Siap Publish',
        'description' => 'Sudah lengkap.',
        'thumbnail' => 'courses/thumbnail.jpg',
        'price' => 50000,
        'is_published' => false,
        'user_id' => $instructor->id,
    ]);
    $module = Module::create([
        'course_id' => $course->id,
        'title' => 'Module Publish',
        'order' => 1,
        'is_published' => true,
    ]);
    Lesson::create([
        'module_id' => $module->id,
        'title' => 'Lesson Publish',
        'order' => 1,
        'is_preview' => false,
    ]);

    $this->actingAs($instructor);

    Livewire::test(EditCourse::class, ['course' => $course])
        ->set('is_published', true)
        ->call('save')
        ->assertHasNoErrors();

    expect((bool) $course->refresh()->is_published)->toBeTrue();
});
