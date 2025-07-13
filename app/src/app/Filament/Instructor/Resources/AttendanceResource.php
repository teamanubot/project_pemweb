<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;
    protected static ?string $navigationGroup = 'Academics';

    public static function table(Table $table): Table
    {
        return $table
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => route('attendance.download', ['filename' => basename($record->file_path)]))
                    ->openUrlInNewTab(true) // WAJIB dibuka di tab baru agar browser force download
                    ->button()
                    ->color('success')
                    ->visible(fn($record) => filled($record->file_path)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {

        $pages = [
            'index' => Pages\ListAttendances::route('/'),
            'student' => Pages\ListStudentAttendances::route('/student'),
            'teacher' => Pages\ListTeacherAttendances::route('/teacher'),
        ];

        return $pages;
    }
}
