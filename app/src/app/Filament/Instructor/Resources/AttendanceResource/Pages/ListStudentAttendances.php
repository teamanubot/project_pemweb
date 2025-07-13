<?php

namespace App\Filament\Instructor\Resources\AttendanceResource\Pages;

use App\Filament\Instructor\Resources\AllAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentAttendances extends ListRecords
{
    protected static string $resource = AllAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
