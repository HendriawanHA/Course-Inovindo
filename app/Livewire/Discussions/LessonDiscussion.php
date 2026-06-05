<?php

namespace App\Livewire\Discussions;

use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\Lesson;
use App\Notifications\NewDiscussionNotification;
use App\Notifications\NewDiscussionReplyNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class LessonDiscussion extends Component
{
    public Lesson $lesson;

    public string $content = '';

    public ?int $replyingTo = null;

    public ?string $replyingName = null;

    public function mount(Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    public function startReply(int $discussionId, string $name): void
    {
        $this->replyingTo = $discussionId;
        $this->replyingName = $name;
        $this->content = '';
    }

    public function cancelReply(): void
    {
        $this->replyingTo = null;
        $this->replyingName = null;
        $this->content = '';
    }

    public function send(): void
    {
        $this->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $course = Course::find($this->lesson->module->course_id);

        if ($this->replyingTo) {
            $reply = DiscussionReply::create([
                'discussion_id' => $this->replyingTo,
                'user_id' => Auth::id(),
                'content' => $this->content,
            ]);

            if ($course && $course->instructor) {
                $course->instructor->notify(new NewDiscussionReplyNotification($reply));
            }
        } else {
            $discussion = Discussion::create([
                'course_id' => $this->lesson->module->course_id,
                'lesson_id' => $this->lesson->id,
                'user_id' => Auth::id(),
                'content' => $this->content,
            ]);

            if ($course && $course->instructor) {
                $course->instructor->notify(new NewDiscussionNotification($discussion));
            }
        }

        $this->reset('content', 'replyingTo', 'replyingName');

        Toaster::success('Diskusi berhasil dikirim.');
    }

    public function render()
    {
        return view('livewire.discussions.lesson-discussion', [
            'discussions' => Discussion::query()
                ->where('lesson_id', $this->lesson->id)
                ->with(['user', 'replies.user'])
                ->latest()
                ->get(),
        ]);
    }
}
