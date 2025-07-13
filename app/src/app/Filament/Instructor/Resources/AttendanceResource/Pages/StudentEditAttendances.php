<?php

namespace App\Filament\Instructor\Resources\AttendanceResource\Pages;

use App\Filament\Instructor\Resources\StudentAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class StudentEditAttendances extends EditRecord
{
    protected static string $resource = StudentAttendanceResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['verified_by_user_id'] = auth('instructor')->id(); // Set user_id secara eksplisit

        return $data;
    }

    protected function canEdit(): bool
    {
        return false; // Tidak boleh edit sama sekali
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
