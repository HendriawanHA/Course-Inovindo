<?php

namespace App\Notifications;

use App\Models\DiscussionReply;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as BaseNotification;

class NewDiscussionReplyNotification extends BaseNotification
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
        return Notification::make()
            ->title('Balasan diskusi baru')
            ->body(
                $this->reply->user->name .
                ' membalas diskusi pada lesson: ' .
                $this->reply->discussion->lesson->title
            )
            ->icon('heroicon-o-chat-bubble-left-right')
            ->color('success')
            ->getDatabaseMessage();
    }
}
