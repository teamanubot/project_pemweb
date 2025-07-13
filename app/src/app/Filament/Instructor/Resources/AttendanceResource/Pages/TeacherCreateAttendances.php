<?php

namespace App\Filament\Instructor\Resources\AttendanceResource\Pages;

use App\Filament\Instructor\Resources\TeacherAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class TeacherCreateAttendances extends CreateRecord
{
    protected static string $resource = TeacherAttendanceResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['verified_by_user_id'] = auth('instructor')->id(); // Set user_id secara eksplisit

        return $data;
    }
    public static string $context = 'teacher';
}
