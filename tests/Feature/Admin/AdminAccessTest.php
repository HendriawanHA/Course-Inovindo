<?php

use App\Models\User;

it('redirects guests from the admin panel to login', function () {
    $this->get('/admin')
        ->assertRedirect('/admin/login');
});

it('allows admins to access the admin panel', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk();
});

it('forbids instructors from the admin panel', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);

    $this->actingAs($instructor)
        ->get('/admin')
        ->assertForbidden();
});

it('forbids students from the admin panel', function () {
    $student = User::factory()->create(['role' => 'student']);

    $this->actingAs($student)
        ->get('/admin')
        ->assertForbidden();
});
