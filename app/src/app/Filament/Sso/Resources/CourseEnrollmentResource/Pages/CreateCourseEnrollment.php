<?php

namespace App\Filament\Sso\Resources\CourseEnrollmentResource\Pages;

use App\Filament\Sso\Resources\CourseEnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCourseEnrollment extends CreateRecord
{
    protected static string $resource = CourseEnrollmentResource::class;
}
