<?php

namespace App\Notifications;

use App\Models\DiscussionReply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewDiscussionReplyNotification extends Notification
{
    use Queueable;

    public function __construct(
        public DiscussionReply $reply
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $discussion = $this->reply->discussion;
        $course = $discussion->course;
        $lesson = $discussion->lesson;

        return [
            'type' => 'discussion_reply',
            'title' => 'Jawaban baru',
            'message' => $this->reply->user->name . ' membalas diskusi di "' . ($lesson?->title ?? $course?->title) . '"',
            'thumbnail' => $course?->thumbnail,
            'url' => route('courses.video', [
                'course' => $course->id,
                'lesson' => $lesson->id,
            ]),
        ];
    }
}
