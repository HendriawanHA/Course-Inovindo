<?php

use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

function createDiscussionForInstructor(User $instructor, User $student): Discussion
{
    $course = Course::create([
        'title' => 'Course Diskusi ' . $instructor->id,
        'description' => 'Course diskusi.',
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

    return Discussion::create([
        'course_id' => $course->id,
        'lesson_id' => $lesson->id,
        'user_id' => $student->id,
        'content' => 'Pertanyaan dari student.',
    ]);
}

it('allows instructors to open discussions for their own course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($instructor, $student);

    $this->actingAs($instructor)
        ->get(route('instructor.courses.discussions', $discussion->course))
        ->assertOk()
        ->assertSee('Pertanyaan dari student.');
});

it('searches discussions by content, student, or lesson for the selected course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create([
        'role' => 'student',
        'name' => 'Budi Searchable',
    ]);
    $discussion = createDiscussionForInstructor($instructor, $student);
    $discussion->update(['content' => 'Pertanyaan tentang middleware Laravel.']);

    $this->actingAs($instructor)
        ->get(route('instructor.courses.discussions', $discussion->course) . '?search=middleware')
        ->assertOk()
        ->assertSee('Pertanyaan tentang middleware Laravel.');

    $this->actingAs($instructor)
        ->get(route('instructor.courses.discussions', $discussion->course) . '?search=Budi')
        ->assertOk()
        ->assertSee('Budi Searchable');
});

it('does not show unmatched discussions when searching', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($instructor, $student);
    $discussion->update(['content' => 'Pertanyaan tentang queue worker.']);

    $response = $this->actingAs($instructor)
        ->get(route('instructor.courses.discussions', $discussion->course) . '?search=tidak-ada')
        ->assertOk();

    // The command palette renders all instructor discussions regardless of page search.
    // Extract only the Thread Diskusi <section> and assert unmatched content is absent.
    $html = $response->getContent();
    preg_match('/Thread Diskusi.*?<\/section>/s', $html, $matches);
    $threadSection = $matches[0] ?? '';
    expect($threadSection)->not->toContain('Pertanyaan tentang queue worker.');
});

it('forbids instructors from opening discussions for another instructors course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($otherInstructor, $student);

    $this->actingAs($instructor)
        ->get(route('instructor.courses.discussions', $discussion->course))
        ->assertForbidden();
});

it('allows instructors to reply to discussions on their own course', function () {
    Notification::fake();

    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($instructor, $student);

    $this->actingAs($instructor)
        ->post(route('instructor.discussions.reply', $discussion), [
            'content' => 'Jawaban dari instructor.',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('discussion_replies', [
        'discussion_id' => $discussion->id,
        'user_id' => $instructor->id,
        'content' => 'Jawaban dari instructor.',
    ]);
});

it('requires content when instructors reply to a discussion', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($instructor, $student);

    $this->actingAs($instructor)
        ->from(route('instructor.courses.discussions', $discussion->course))
        ->post(route('instructor.discussions.reply', $discussion), [
            'content' => '',
        ])
        ->assertSessionHasErrors('content');
});

it('forbids instructors from replying to discussions on another instructors course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($otherInstructor, $student);

    $this->actingAs($instructor)
        ->post(route('instructor.discussions.reply', $discussion), [
            'content' => 'Balasan tidak sah.',
        ])
        ->assertForbidden();

    expect(DiscussionReply::count())->toBe(0);
});

it('allows instructors to delete a discussion on their own course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($instructor, $student);

    $this->actingAs($instructor)
        ->delete(route('instructor.discussions.destroy', $discussion))
        ->assertRedirect();

    $this->assertDatabaseMissing('discussions', ['id' => $discussion->id]);
});

it('cascades reply deletion when parent discussion is deleted', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($instructor, $student);

    $reply = DiscussionReply::create([
        'discussion_id' => $discussion->id,
        'user_id' => $instructor->id,
        'content' => 'Balasan dari instructor.',
    ]);

    $this->actingAs($instructor)
        ->delete(route('instructor.discussions.destroy', $discussion))
        ->assertRedirect();

    $this->assertDatabaseMissing('discussions', ['id' => $discussion->id]);
    $this->assertDatabaseMissing('discussion_replies', ['id' => $reply->id]);
});

it('allows instructors to delete a reply on their own course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($instructor, $student);

    $reply = DiscussionReply::create([
        'discussion_id' => $discussion->id,
        'user_id' => $student->id,
        'content' => 'Balasan dari student.',
    ]);

    $this->actingAs($instructor)
        ->delete(route('instructor.discussions.replies.destroy', $reply))
        ->assertRedirect();

    $this->assertDatabaseMissing('discussion_replies', ['id' => $reply->id]);
});

it('cascades child reply deletion when parent reply is deleted', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($instructor, $student);

    $parentReply = DiscussionReply::create([
        'discussion_id' => $discussion->id,
        'user_id' => $student->id,
        'content' => 'Balasan parent.',
    ]);

    $childReply = DiscussionReply::create([
        'discussion_id' => $discussion->id,
        'user_id' => $instructor->id,
        'parent_id' => $parentReply->id,
        'content' => 'Balasan child.',
    ]);

    $this->actingAs($instructor)
        ->delete(route('instructor.discussions.replies.destroy', $parentReply))
        ->assertRedirect();

    $this->assertDatabaseMissing('discussion_replies', ['id' => $parentReply->id]);
    $this->assertDatabaseMissing('discussion_replies', ['id' => $childReply->id]);
});

it('forbids instructors from deleting discussions on another instructors course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($otherInstructor, $student);

    $this->actingAs($instructor)
        ->delete(route('instructor.discussions.destroy', $discussion))
        ->assertForbidden();

    $this->assertDatabaseHas('discussions', ['id' => $discussion->id]);
});

it('forbids instructors from deleting replies on another instructors course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $otherInstructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($otherInstructor, $student);

    $reply = DiscussionReply::create([
        'discussion_id' => $discussion->id,
        'user_id' => $student->id,
        'content' => 'Balasan dari student.',
    ]);

    $this->actingAs($instructor)
        ->delete(route('instructor.discussions.replies.destroy', $reply))
        ->assertForbidden();

    $this->assertDatabaseHas('discussion_replies', ['id' => $reply->id]);
});

it('does not allow students to delete discussions or replies', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $student = User::factory()->create(['role' => 'student']);
    $discussion = createDiscussionForInstructor($instructor, $student);

    $reply = DiscussionReply::create([
        'discussion_id' => $discussion->id,
        'user_id' => $student->id,
        'content' => 'Balasan dari student.',
    ]);

    $this->actingAs($student)
        ->delete(route('instructor.discussions.destroy', $discussion))
        ->assertForbidden();

    $this->actingAs($student)
        ->delete(route('instructor.discussions.replies.destroy', $reply))
        ->assertForbidden();

    $this->assertDatabaseHas('discussions', ['id' => $discussion->id]);
    $this->assertDatabaseHas('discussion_replies', ['id' => $reply->id]);
});
