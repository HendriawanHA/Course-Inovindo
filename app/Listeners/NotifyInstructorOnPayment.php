<?php

namespace App\Listeners;

use App\Events\TransactionPaid;
use App\Notifications\CoursePurchasedNotification;

class NotifyInstructorOnPayment
{
    public function handle(TransactionPaid $event): void
    {
        $transaction = $event->transaction;
        $course = $transaction->course()->with('instructor')->first();

        if ($course?->instructor) {
            $course->instructor->notify(
                new CoursePurchasedNotification($transaction)
            );
        }
    }
}
