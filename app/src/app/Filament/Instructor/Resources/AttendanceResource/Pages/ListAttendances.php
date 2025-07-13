<?php

namespace App\Filament\Instructor\Resources\AttendanceResource\Pages;

use App\Filament\Instructor\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\Page;

class ListAttendances extends Page
{
    protected static string $resource = AttendanceResource::class;
    protected static string $view = 'filament.list-attendances';
}
