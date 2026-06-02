<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use App\Models\User;
use App\Notifications\NewEventNotification;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function afterCreate(): void
    {
        $event = $this->record;

        $students = User::where(
            'role',
            'student'
        )->get();
        foreach ($students as $student) {

            $student->notify(
                new NewEventNotification($event)
            );
        }
    }
}
