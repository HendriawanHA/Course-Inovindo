<?php

namespace App\Notifications;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCourseNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Course $course
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [

            'type' => 'course',

            'title' => 'New Course Available',

            'message' => $this->course->title,

            'course_id' => $this->course->id,

            'thumbnail' => $this->course->thumbnail,
            
            'url' => route(
                'courses.show',
                $this->course->id
            ),

        ];
    }
}
