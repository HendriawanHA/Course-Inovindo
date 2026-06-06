<?php

use App\Models\User;

it('redirects guests from the instructor dashboard to login', function () {
    $this->get('/instructor')
        ->assertRedirect('/login');
});

it('allows instructors to access the instructor dashboard', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    $this->actingAs($instructor)
        ->get(route('instructor.dashboard'))
        ->assertOk();
});

it('forbids admins from the instructor dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('instructor.dashboard'))
        ->assertForbidden();
});

it('forbids students from the instructor dashboard', function () {
    $student = User::factory()->create(['role' => 'student']);

    $this->actingAs($student)
        ->get(route('instructor.dashboard'))
        ->assertForbidden();
});
