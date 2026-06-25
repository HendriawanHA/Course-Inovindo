<?php

use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('shows admin discussions list page with all courses', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $instructor = User::factory()->create(['role' => 'instructor']);

    $course = Course::create([
        'title' => 'Test Course',
        'description' => 'Test',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);

    $this->actingAs($admin)
        ->get('/admin/discussions')
        ->assertOk()
        ->assertSee('Test Course')
        ->assertSee('courses')
        ->assertSee('total diskusi');
});

it('forbids non-admin from accessing discussions list', function () {
    $student = User::factory()->create(['role' => 'student']);

    $this->actingAs($student)
        ->get('/admin/discussions')
        ->assertForbidden();
});

it('shows course thread page for admin with master-detail layout', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);

    $course = Course::create([
        'title' => 'Thread Course',
        'description' => 'Test',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);
    $module = Module::create([
        'course_id' => $course->id,
        'title' => 'Test Module',
        'order' => 1,
        'is_published' => true,
    ]);
    $lesson = Lesson::create([
        'module_id' => $module->id,
        'title' => 'Test Lesson',
        'order' => 1,
        'is_preview' => false,
    ]);
    $discussion = Discussion::create([
        'course_id' => $course->id,
        'lesson_id' => $lesson->id,
        'user_id' => $student->id,
        'content' => 'Pertanyaan test.',
    ]);

    $response = $this->actingAs($admin)
        ->get('/admin/discussions/' . $course->id);

    $response->assertOk();
    $response->assertSee('Thread Course');
    $response->assertSee('Pertanyaan test.');
    $response->assertSee('Semua Course');
    $response->assertSee('Belum dibalas');
});

it('shows sidebar courses on detail page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);

    $course1 = Course::create([
        'title' => 'Course Alpha',
        'description' => 'Test',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);
    $course2 = Course::create([
        'title' => 'Course Beta',
        'description' => 'Test',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);
    $module = Module::create([
        'course_id' => $course1->id,
        'title' => 'Test Module',
        'order' => 1,
        'is_published' => true,
    ]);
    $lesson = Lesson::create([
        'module_id' => $module->id,
        'title' => 'Test Lesson',
        'order' => 1,
        'is_preview' => false,
    ]);
    Discussion::create([
        'course_id' => $course1->id,
        'lesson_id' => $lesson->id,
        'user_id' => $student->id,
        'content' => 'Test.',
    ]);

    $response = $this->actingAs($admin)
        ->get('/admin/discussions/' . $course1->id);

    $response->assertOk();
    $response->assertSee('Course Alpha');
    $response->assertSee('Course Beta');
    $response->assertSee('Kembali ke semua course');
});

it('forbids non-admin from accessing course thread', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);

    $course = Course::create([
        'title' => 'Test',
        'description' => 'Test',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);

    $this->actingAs($student)
        ->get('/admin/discussions/' . $course->id)
        ->assertForbidden();
});

it('admin can delete a discussion on the thread page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);

    $course = Course::create([
        'title' => 'Delete Test',
        'description' => 'Test',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);
    $module = Module::create([
        'course_id' => $course->id,
        'title' => 'M1',
        'order' => 1,
        'is_published' => true,
    ]);
    $lesson = Lesson::create([
        'module_id' => $module->id,
        'title' => 'L1',
        'order' => 1,
        'is_preview' => false,
    ]);
    $discussion = Discussion::create([
        'course_id' => $course->id,
        'lesson_id' => $lesson->id,
        'user_id' => $student->id,
        'content' => 'To be deleted.',
    ]);

    Livewire::actingAs($admin)
        ->test(\App\Filament\Pages\DiscussionsView::class, ['course' => $course])
        ->assertSee('To be deleted.')
        ->call('deleteDiscussion', $discussion->id);

    $this->assertDatabaseMissing('discussions', ['id' => $discussion->id]);
});

it('admin can delete a reply on the thread page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);

    $course = Course::create([
        'title' => 'Reply Delete',
        'description' => 'Test',
        'price' => 100000,
        'is_published' => true,
        'user_id' => $instructor->id,
    ]);
    $module = Module::create([
        'course_id' => $course->id,
        'title' => 'M1',
        'order' => 1,
        'is_published' => true,
    ]);
    $lesson = Lesson::create([
        'module_id' => $module->id,
        'title' => 'L1',
        'order' => 1,
        'is_preview' => false,
    ]);
    $discussion = Discussion::create([
        'course_id' => $course->id,
        'lesson_id' => $lesson->id,
        'user_id' => $student->id,
        'content' => 'Question.',
    ]);
    $reply = DiscussionReply::create([
        'discussion_id' => $discussion->id,
        'user_id' => $instructor->id,
        'content' => 'Reply to delete.',
    ]);

    Livewire::actingAs($admin)
        ->test(\App\Filament\Pages\DiscussionsView::class, ['course' => $course])
        ->assertSee('Reply to delete.')
        ->call('deleteReply', $reply->id);

    $this->assertDatabaseMissing('discussion_replies', ['id' => $reply->id]);
});
