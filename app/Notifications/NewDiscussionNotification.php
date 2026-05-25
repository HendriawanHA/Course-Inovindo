<?php

namespace App\Notifications;

use App\Models\Discussion;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as BaseNotification;

class NewDiscussionNotification extends BaseNotification
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
        return Notification::make()
            ->title('Diskusi baru')
            ->body($this->discussion->user->name . ' bertanya di lesson: ' . $this->discussion->lesson->title)
            ->icon('heroicon-o-chat-bubble-left-right')
            ->color('primary')
            ->getDatabaseMessage();
    }
}
