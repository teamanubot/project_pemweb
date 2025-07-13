<?php

namespace App\Filament\Instructor\Resources\AttendanceResource\Pages;

use App\Filament\Instructor\Resources\TeacherAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class TeacherEditAttendances extends EditRecord
{
    protected static string $resource = TeacherAttendanceResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['verified_by_user_id'] = auth('instructor')->id(); // Set user_id secara eksplisit

        return $data;
    }

    public function mount($record): void
    {
        parent::mount($record);

        /** @var \App\Models\User|null $user */
        $user = auth('instructor')->user();

        if ($user && $user->hasRole('teacher', 'instructor')) {
            $this->redirect('/instructor/attendances/teacher');
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
