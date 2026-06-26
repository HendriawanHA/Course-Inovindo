<?php

namespace App\Listeners;

use App\Events\TransactionPaid;
use App\Models\Enrollment;

class CreateEnrollmentOnPayment
{
    public function handle(TransactionPaid $event): void
    {
        $transaction = $event->transaction;

        if ($transaction->paid_at === null) {
            $transaction->forceFill(['paid_at' => now()])->save();
        }

        if ($transaction->course_id) {
            Enrollment::firstOrCreate(
                [
                    'user_id' => $transaction->user_id,
                    'course_id' => $transaction->course_id,
                ],
                [
                    'status' => 'active',
                    'progress' => 0,
                    'enrolled_at' => now(),
                ]
            );
        }
    }
}
