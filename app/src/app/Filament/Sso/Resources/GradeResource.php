<?php

namespace App\Filament\Sso\Resources;

use App\Filament\Sso\Resources\GradeResource\Pages;
use App\Filament\Sso\Resources\GradeResource\RelationManagers;
use App\Models\Grade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationGroup = 'Assessments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'name')
                    ->required(),
                Forms\Components\TextInput::make('quiz_assignment_score')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('attendance_percentage')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('mid_eval_score')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('final_eval_score')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('project_score')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('final_grade')
                    ->numeric()
                    ->default(null),
                Forms\Components\Toggle::make('is_passed')
                    ->required(),
                Forms\Components\DateTimePicker::make('graded_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quiz_assignment_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attendance_percentage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mid_eval_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('final_eval_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('final_grade')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_passed')
                    ->boolean(),
                Tables\Columns\TextColumn::make('graded_at')
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
            'index' => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'edit' => Pages\EditGrade::route('/{record}/edit'),
        ];
    }
}
