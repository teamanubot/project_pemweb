<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\SallaryResource\Pages;
use App\Filament\Instructor\Resources\SallaryResource\RelationManagers;
use App\Models\Sallary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SallaryResource extends Resource
{
    protected static ?string $model = Sallary::class;

    protected static ?string $navigationGroup = 'Finance & Payroll';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\TextInput::make('month')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('year')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('base_salary')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('overtime_pay')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('alpha_deduction')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('excess_leave_deduction')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('total_gross_salary')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_net_salary')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('generated_at')
                    ->required(),
                Forms\Components\TextInput::make('generated_by_user_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('month')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_salary')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('overtime_pay')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alpha_deduction')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('excess_leave_deduction')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_gross_salary')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_net_salary')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('generated_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('generated_by_user_id')
                    ->numeric()
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        /** @var \App\Models\User|null $user */
        $user = auth('instructor')->user();

        if ($user && $user->hasRole('teacher')) {
            return parent::getEloquentQuery()
                ->where('user_id', $user->id);
        }

        return parent::getEloquentQuery()->whereRaw('1 = 0'); // Non-teacher tidak bisa lihat apa pun
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSallaries::route('/'),
            'create' => Pages\CreateSallary::route('/create'),
            'edit' => Pages\EditSallary::route('/{record}/edit'),
        ];
    }
}
