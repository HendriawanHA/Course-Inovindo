<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use App\Models\User;
use App\Notifications\NewCourseNotification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        if ($user && $user->role === 'instructor') {

            $data['user_id'] = $user->id;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $course = $this->record;

        $students = User::where(
            'role',
            'student'
        )->get();

        foreach ($students as $student) {

            $student->notify(
                new NewCourseNotification($course)
            );
        }
    }
}
