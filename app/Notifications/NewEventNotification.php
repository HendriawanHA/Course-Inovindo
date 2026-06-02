<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewEventNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Event $event
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [

            'type' => 'event',

            'title' => 'New Event Available',

            'message' => $this->event->title,

            'event_id' => $this->event->id,

            'thumbnail' => $this->event->thumbnail,

            'url' => route(
                'events.show',
                $this->event->slug
            ),

        ];
    }
}
