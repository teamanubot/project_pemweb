<?php

namespace App\Filament\Instructor\Resources\AttendanceResource\Pages;

use App\Filament\Instructor\Resources\StudentAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class StudentCreateAttendances extends CreateRecord
{
    protected static string $resource = StudentAttendanceResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['verified_by_user_id'] = auth('instructor')->id(); // Set user_id secara eksplisit

        return $data;
    }
    public static string $context = 'student';
}
