<?php

namespace App\Support;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class AdminNotification
{
    public static function send(Notification $notification): void
    {
        $admins = self::admins();

        if ($admins->isEmpty()) {
            return;
        }

        $notification->sendToDatabase($admins);
    }

    private static function admins(): Collection
    {
        return User::query()
            ->where('role', 'admin')
            ->get();
    }
}
