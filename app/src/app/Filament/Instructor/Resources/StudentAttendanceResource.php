<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\AttendanceResource\Pages;
use App\Filament\Instructor\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

class StudentAttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationGroup = 'Academics';

    public static function form(Form $form, ?string $context = null): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Student')
                    ->options(fn() => User::whereHas('roles', fn($q) => $q->where('name', 'student'))->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
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
                Forms\Components\TextInput::make('proof_file_path')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Select::make('verified_by_user_id')
                    ->options(function () {
                        $user = auth('instructor')->user();
                        return $user ? [$user->id => $user->name] : [];
                    })
                    ->default(auth('instructor')->id())
                    ->disabled()
                    ->required()
                    ->dehydrated(),
                Forms\Components\DateTimePicker::make('verified_at')
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
        ];
    }
}
