<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Resources\Resource;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;
    protected static ?string $navigationGroup = 'Academics';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'student' => Pages\ListStudentAttendances::route('/student'),
            'teacher' => Pages\ListTeacherAttendances::route('/teacher'),
        ];
    }
}