<?php

namespace App\Filament\Sso\Resources\CourseEnrollmentResource\Pages;

use App\Filament\Sso\Resources\CourseEnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseEnrollment extends EditRecord
{
    protected static string $resource = CourseEnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
