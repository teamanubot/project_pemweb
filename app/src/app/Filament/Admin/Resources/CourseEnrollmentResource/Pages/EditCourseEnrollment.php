<?php

namespace App\Filament\Admin\Resources\CourseEnrollmentResource\Pages;

use App\Filament\Admin\Resources\CourseEnrollmentResource;
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
