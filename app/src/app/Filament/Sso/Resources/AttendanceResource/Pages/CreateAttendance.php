<?php

namespace App\Filament\Sso\Resources\AttendanceResource\Pages;

use App\Filament\Sso\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['verified_by_user_id'] = auth('instructor')->id(); // Set user_id secara eksplisit

        return $data;
    }
}
