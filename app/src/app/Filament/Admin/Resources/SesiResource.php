<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SesiResource\Pages;
use App\Filament\Admin\Resources\SesiResource\RelationManagers;
use App\Models\Sesi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SesiResource extends Resource
{
    protected static ?string $model = Sesi::class;

    protected static ?string $navigationGroup = 'Student Affairs';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'name')
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher', 'name')
                    ->required(),
                Forms\Components\TextInput::make('session_number')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('session_type')
                    ->required(),
                Forms\Components\TextInput::make('delivery_method')
                    ->required(),
                Forms\Components\DatePicker::make('session_date')
                    ->required(),
                Forms\Components\TextInput::make('start_time')
                    ->required(),
                Forms\Components\TextInput::make('end_time')
                    ->required(),
                Forms\Components\TextInput::make('online_link')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('branch_office_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('syllabus_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('session_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('session_type'),
                Tables\Columns\TextColumn::make('delivery_method'),
                Tables\Columns\TextColumn::make('session_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time'),
                Tables\Columns\TextColumn::make('end_time'),
                Tables\Columns\TextColumn::make('online_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('branch_office_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('syllabus_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
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
            'index' => Pages\ListSesis::route('/'),
            'create' => Pages\CreateSesi::route('/create'),
            'edit' => Pages\EditSesi::route('/{record}/edit'),
        ];
    }
}
