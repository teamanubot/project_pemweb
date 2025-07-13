<?php

namespace App\Filament\Sso\Resources;

use App\Filament\Sso\Resources\AttendanceResource\Pages;
use App\Filament\Sso\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationGroup = 'Academics';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Nama')
                    ->options(function () {
                        $user = auth('student')->user();
                        return $user ? [$user->id => $user->name] : [];
                    })
                    ->default(auth('student')->id())
                    ->disabled()
                    ->required()
                    ->dehydrated(),
                Forms\Components\TextInput::make('sesi_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('attendance_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('clock_in_time'),
                Forms\Components\DateTimePicker::make('clock_out_time'),
                Forms\Components\Select::make('status')
                    ->label('Attendance Status')
                    ->required()
                    ->options([
                        'present' => 'Present',
                        'late'    => 'Late',
                        'absent'  => 'Absent',
                        'sick'    => 'Sick',
                        'leave'   => 'Leave',
                        'alpha'   => 'Alpha',
                    ]),
                Forms\Components\FileUpload::make('proof_file_path')
                    ->label('Upload Bukti')
                    ->directory('Attendance') // folder penyimpanan di storage/app/public/Attendance
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword', // .doc
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
                        'image/*',
                    ])
                    ->maxSize(102400) // maksimal 2MB
                    ->disk('public') // gunakan disk 'public' (pastikan `php artisan storage:link` sudah dijalankan)
                    ->nullable()
                    ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                        $user = \App\Models\User::find($get('user_id'));
                        $attendance = \App\Models\Attendance::find($get('attendance_id'));

                        $userName = $user?->name ?? 'user';
                        $attendanceDate = $attendance?->attendance_date->format('Y-m-d') ?? 'date';

                        $extension = $file->getClientOriginalExtension();

                        return "{$userName} - {$attendanceDate}.{$extension}";
                    }),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Select::make('verified_by_user_id')
                    ->default(null)
                    ->hidden(),
                Forms\Components\DateTimePicker::make('verified_at')
                    ->default(null)
                    ->hidden(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sesi_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attendance_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('clock_in_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('clock_out_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('proof_file_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('verified_by_user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        /** @var \App\Models\User|null $user */
        $user = auth('student')->user();

        if ($user && $user->hasRole('student')) {
            return parent::getEloquentQuery()
                ->where('user_id', $user->id);
        }

        return parent::getEloquentQuery()->whereRaw('1 = 0'); // Non-teacher tidak bisa lihat apa pun
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}