<?php

namespace App\Notifications;

use App\Models\DiscussionReply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StudentDiscussionReplyNotification extends Notification
{
    use Queueable;

    public function __construct(
        public DiscussionReply $reply
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $discussion = $this->reply->discussion;
        $course = $discussion->course;

        return [

            'type' => 'discussion_reply',

            'title' => 'Instructor replied',

            'message' =>
            $this->reply->user->name .
                ' replied to your discussion',

            'thumbnail' => $course?->thumbnail,

            'url' => route(
                'courses.video',
                [
                    'course' => $discussion->course_id,
                    'lesson' => $discussion->lesson_id,
                ]
            ),
        ];
    }
}
