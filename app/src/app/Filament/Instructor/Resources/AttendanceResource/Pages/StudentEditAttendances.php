<?php

namespace App\Filament\Instructor\Resources\AttendanceResource\Pages;

use App\Filament\Instructor\Resources\AllAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class StudentEditAttendances extends EditRecord
{
    protected static string $resource = AllAttendanceResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['verified_by_user_id'] = auth('instructor')->id(); // Set user_id secara eksplisit

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
