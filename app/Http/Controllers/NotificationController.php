<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function read(DatabaseNotification $notification)
    {
        if ($notification->notifiable_id === auth()->id()) {

            $notification->markAsRead();
        }

        return redirect(
            $notification->data['url'] ?? '/'
        );
    }
}
