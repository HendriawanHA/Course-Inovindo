<?php

use App\Filament\Resources\Transactions\Pages\ListTransactions;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Transaction;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

it('allows admins to mark a pending transaction as paid and enroll the student', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'student']);
    $instructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Transaksi',
        'description' => 'Course untuk transaksi.',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);
    $transaction = Transaction::create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'invoice_number' => 'INV-TEST-001',
        'amount' => 100000,
        'status' => 'pending',
    ]);

    $this->actingAs($admin);

    Livewire::test(ListTransactions::class)
        ->callTableAction('markAsPaid', $transaction);

    expect($transaction->refresh()->status)->toBe('paid')
        ->and($transaction->paid_at)->not->toBeNull();

    $this->assertDatabaseHas('enrollments', [
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'active',
    ]);
});

it('does not duplicate enrollment when a paid transaction is approved again', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'student']);
    $instructor = User::factory()->create(['role' => 'instructor']);
    $course = Course::create([
        'title' => 'Course Enrollment Existing',
        'description' => 'Course untuk transaksi.',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);
    $transaction = Transaction::create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'invoice_number' => 'INV-TEST-002',
        'amount' => 100000,
        'status' => 'pending',
    ]);

    Enrollment::create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'active',
        'progress' => 0,
        'enrolled_at' => now(),
    ]);

    $this->actingAs($admin);

    Livewire::test(ListTransactions::class)
        ->callTableAction('markAsPaid', $transaction);

    expect(Enrollment::where('user_id', $student->id)->where('course_id', $course->id)->count())
        ->toBe(1);
});
