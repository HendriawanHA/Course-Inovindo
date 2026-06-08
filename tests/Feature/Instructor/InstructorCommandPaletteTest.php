<?php

use App\Livewire\Instructor\CommandPalette;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Livewire\Livewire;

it('starts with the palette closed', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->assertSet('open', false)
        ->assertSet('search', '');
});

it('opens the palette when the open-command-palette event is received', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->assertSet('open', false)
        ->dispatch('open-command-palette')
        ->assertSet('open', true);
});

it('closes the palette and clears search', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->dispatch('open-command-palette')
        ->set('search', 'laravel')
        ->call('closePalette')
        ->assertSet('open', false)
        ->assertSet('search', '');
});

it('returns only courses owned by the authenticated instructor', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);

    Course::create([
        'title' => 'My Laravel Course',
        'description' => 'Milik saya.',
        'price' => 100000,
        'user_id' => $instructor->id,
    ]);

    Course::create([
        'title' => 'Other Laravel Course',
        'description' => 'Milik instructor lain.',
        'price' => 100000,
        'user_id' => $otherInstructor->id,
    ]);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->dispatch('open-command-palette')
        ->assertSee('My Laravel Course')
        ->assertDontSee('Other Laravel Course');
});

it('searches courses by title and description', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    Course::create([
        'title' => 'Laravel Advanced',
        'description' => 'Course advanced.',
        'price' => 100000,
        'user_id' => $instructor->id,
    ]);

    Course::create([
        'title' => 'Vue.js Basics',
        'description' => 'Course Vue.',
        'price' => 100000,
        'user_id' => $instructor->id,
    ]);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->dispatch('open-command-palette')
        ->set('search', 'Laravel')
        ->assertSee('Laravel Advanced')
        ->assertDontSee('Vue.js Basics');
});

it('returns students enrolled in the instructor courses only', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);
    $studentOne = User::factory()->create(['role' => 'student', 'name' => 'Alice']);
    $studentTwo = User::factory()->create(['role' => 'student', 'name' => 'Bob']);

    $myCourse = Course::create([
        'title' => 'My Course',
        'description' => 'Course saya.',
        'price' => 100000,
        'user_id' => $instructor->id,
    ]);

    $otherCourse = Course::create([
        'title' => 'Other Course',
        'description' => 'Course lain.',
        'price' => 100000,
        'user_id' => $otherInstructor->id,
    ]);

    Enrollment::create([
        'user_id' => $studentOne->id,
        'course_id' => $myCourse->id,
        'status' => 'active',
        'progress' => 50,
        'enrolled_at' => now(),
    ]);

    Enrollment::create([
        'user_id' => $studentTwo->id,
        'course_id' => $otherCourse->id,
        'status' => 'active',
        'progress' => 50,
        'enrolled_at' => now(),
    ]);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->dispatch('open-command-palette')
        ->assertSee('Alice')
        ->assertDontSee('Bob');
});

it('searches students by name and email', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $studentOne = User::factory()->create(['role' => 'student', 'name' => 'Charlie', 'email' => 'charlie@example.com']);
    $studentTwo = User::factory()->create(['role' => 'student', 'name' => 'David', 'email' => 'david@example.com']);

    $course = Course::create([
        'title' => 'Course Search Student',
        'description' => 'Untuk search.',
        'price' => 100000,
        'user_id' => $instructor->id,
    ]);

    Enrollment::create([
        'user_id' => $studentOne->id,
        'course_id' => $course->id,
        'status' => 'active',
        'progress' => 50,
        'enrolled_at' => now(),
    ]);

    Enrollment::create([
        'user_id' => $studentTwo->id,
        'course_id' => $course->id,
        'status' => 'active',
        'progress' => 50,
        'enrolled_at' => now(),
    ]);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->dispatch('open-command-palette')
        ->set('search', 'Charlie')
        ->assertSee('Charlie')
        ->assertDontSee('David');
});

it('returns discussions from the instructor courses only', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);

    $myCourse = Course::create([
        'title' => 'My Course',
        'description' => 'Course saya.',
        'price' => 100000,
        'user_id' => $instructor->id,
    ]);
    $module = Module::create(['course_id' => $myCourse->id, 'title' => 'Mod', 'order' => 1, 'is_published' => true]);
    $lesson = Lesson::create(['module_id' => $module->id, 'title' => 'Les', 'order' => 1, 'is_preview' => false]);

    $otherCourse = Course::create([
        'title' => 'Other Course',
        'description' => 'Course lain.',
        'price' => 100000,
        'user_id' => $otherInstructor->id,
    ]);
    $otherModule = Module::create(['course_id' => $otherCourse->id, 'title' => 'Mod2', 'order' => 1, 'is_published' => true]);
    $otherLesson = Lesson::create(['module_id' => $otherModule->id, 'title' => 'Les2', 'order' => 1, 'is_preview' => false]);

    Discussion::create([
        'course_id' => $myCourse->id,
        'lesson_id' => $lesson->id,
        'user_id' => $student->id,
        'content' => 'Pertanyaan Laravel?',
    ]);

    Discussion::create([
        'course_id' => $otherCourse->id,
        'lesson_id' => $otherLesson->id,
        'user_id' => $student->id,
        'content' => 'Pertanyaan Vue?',
    ]);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->dispatch('open-command-palette')
        ->assertSee('Pertanyaan Laravel?')
        ->assertDontSee('Pertanyaan Vue?');
});

it('searches discussions by content', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);

    $course = Course::create([
        'title' => 'Course Diskusi',
        'description' => 'Course diskusi.',
        'price' => 100000,
        'user_id' => $instructor->id,
    ]);
    $module = Module::create(['course_id' => $course->id, 'title' => 'Mod', 'order' => 1, 'is_published' => true]);
    $lesson = Lesson::create(['module_id' => $module->id, 'title' => 'Les', 'order' => 1, 'is_preview' => false]);

    Discussion::create([
        'course_id' => $course->id,
        'lesson_id' => $lesson->id,
        'user_id' => $student->id,
        'content' => 'Bagaimana cara menggunakan Livewire?',
    ]);

    Discussion::create([
        'course_id' => $course->id,
        'lesson_id' => $lesson->id,
        'user_id' => $student->id,
        'content' => 'Cara deploy ke Vercel?',
    ]);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->dispatch('open-command-palette')
        ->set('search', 'Livewire')
        ->assertSee('Bagaimana cara menggunakan Livewire?')
        ->assertDontSee('Cara deploy ke Vercel?');
});

it('shows empty state when no results match', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->dispatch('open-command-palette')
        ->set('search', 'nonexistent')
        ->assertSee('No results for');
});

it('searches students by course title', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student', 'name' => 'Eve']);

    $course = Course::create([
        'title' => 'Laravel Mastery',
        'description' => 'Advanced course.',
        'price' => 100000,
        'user_id' => $instructor->id,
    ]);

    Enrollment::create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'active',
        'progress' => 50,
        'enrolled_at' => now(),
    ]);

    $this->actingAs($instructor);

    Livewire::test(CommandPalette::class)
        ->dispatch('open-command-palette')
        ->set('search', 'Laravel Mastery')
        ->assertSee('Eve')
        ->assertSee('Laravel Mastery');
});
