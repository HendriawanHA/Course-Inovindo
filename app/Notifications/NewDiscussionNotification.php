<?php

namespace App\Notifications;

use App\Models\Discussion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewDiscussionNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Discussion $discussion
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $course = $this->discussion->course;
        $lesson = $this->discussion->lesson;

        return [
            'type' => 'new_discussion',
            'title' => 'Diskusi baru',
            'message' => $this->discussion->user->name . ' bertanya di "' . ($lesson?->title ?? $course?->title) . '"',
            'thumbnail' => $course?->thumbnail,
            'url' => route('courses.video', [
                'course' => $course->id,
                'lesson' => $lesson->id,
            ]),
        ];
    }
}
