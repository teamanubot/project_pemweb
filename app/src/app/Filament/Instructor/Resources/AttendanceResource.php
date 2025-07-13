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
        /** @var \App\Models\User|null $user */
        $user = auth('instructor')->user();

        $pages = [
            'index' => Pages\ListAttendances::route('/'),
            'student' => Pages\ListStudentAttendances::route('/student'),
            'student-create' => Pages\StudentCreateAttendances::route('/student/create'),
            'student-edit' => Pages\StudentEditAttendances::route('/student/{record}/edit'),
            'teacher' => Pages\ListTeacherAttendances::route('/teacher'),
            'teacher-create' => Pages\TeacherCreateAttendances::route('/teacher/create'),
            'teacher-edit' => Pages\TeacherEditAttendances::route('/teacher/{record}/edit'),
        ];

        if (!$user || !$user->hasRole('teacher', 'instructor')) {
            $pages['edit'] = Pages\TeacherEditAttendances::route('/teacher/{record}/edit');
        }

        return $pages;
    }
}
