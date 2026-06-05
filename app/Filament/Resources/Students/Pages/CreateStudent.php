<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
        protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'student';
        $data['email_verified_at'] = now();

        return $data;
    }

}
