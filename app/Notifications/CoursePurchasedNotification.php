<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CoursePurchasedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Transaction $transaction
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $transaction = $this->transaction->load(['user', 'course']);

        return [
            'type' => 'purchase',
            'title' => 'Course baru dibeli',
            'message' => "{$transaction->user->name} membeli course \"{$transaction->course->title}\".",
            'student_name' => $transaction->user->name,
            'course_id' => $transaction->course_id,
            'course_title' => $transaction->course->title,
            'thumbnail' => $transaction->course->thumbnail,
            'url' => route('instructor.courses.discussions', $transaction->course_id),
        ];
    }
}
