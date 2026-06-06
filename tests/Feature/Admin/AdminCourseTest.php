<?php

use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Courses\Pages\CreateCourse;
use App\Filament\Resources\Courses\Pages\EditCourse;
use App\Models\Course;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

it('allows admins to open the course create page', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(CourseResource::getUrl('create'))
        ->assertOk();
});

it('requires admins to select an instructor when creating a course', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin);

    Livewire::test(CreateCourse::class)
        ->fillForm([
            'title' => 'Course Tanpa Instructor',
            'description' => 'Course ini tidak memilih instructor.',
            'price' => 100000,
            'is_published' => false,
            'modules' => [],
        ])
        ->call('create')
        ->assertHasFormErrors(['user_id' => 'required']);
});

it('allows admins to create a course for an instructor', function () {
    Notification::fake();

    $admin = User::factory()->create(['role' => 'admin']);
    $instructor = User::factory()->create(['role' => 'instructor']);

    $this->actingAs($admin);

    Livewire::test(CreateCourse::class)
        ->fillForm([
            'title' => 'Laravel untuk Pemula',
            'description' => 'Belajar Laravel dari dasar.',
            'price' => 150000,
            'is_published' => false,
            'user_id' => $instructor->id,
            'modules' => [],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('courses', [
        'title' => 'Laravel untuk Pemula',
        'user_id' => $instructor->id,
    ]);
});

it('allows admins to edit a course', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $instructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Lama',
        'description' => 'Deskripsi lama.',
        'price' => 100000,
        'is_published' => false,
        'user_id' => $instructor->id,
    ]);

    $this->actingAs($admin);

    Livewire::test(EditCourse::class, ['record' => $course->getRouteKey()])
        ->fillForm([
            'title' => 'Course Baru',
            'description' => 'Deskripsi baru.',
            'price' => 200000,
            'is_published' => false,
            'user_id' => $instructor->id,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($course->refresh()->title)->toBe('Course Baru');
});
