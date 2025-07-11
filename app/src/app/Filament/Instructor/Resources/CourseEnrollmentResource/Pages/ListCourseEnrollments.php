<?php

namespace App\Filament\Instructor\Resources\CourseEnrollmentResource\Pages;

use App\Filament\Instructor\Resources\CourseEnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseEnrollments extends ListRecords
{
    protected static string $resource = CourseEnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
