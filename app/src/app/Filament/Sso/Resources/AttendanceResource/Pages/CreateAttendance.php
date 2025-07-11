<?php

namespace App\Filament\Sso\Resources\AttendanceResource\Pages;

use App\Filament\Sso\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;
}
