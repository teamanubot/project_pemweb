<?php

namespace App\Filament\Instructor\Resources\CourseEnrollmentResource\Pages;

use App\Filament\Instructor\Resources\CourseEnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCourseEnrollment extends CreateRecord
{
    protected static string $resource = CourseEnrollmentResource::class;
}
