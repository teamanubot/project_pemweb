<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PayrollSettingResource\Pages;
use App\Filament\Admin\Resources\PayrollSettingResource\RelationManagers;
use App\Models\PayrollSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayrollSettingResource extends Resource
{
    protected static ?string $model = PayrollSetting::class;

    protected static ?string $navigationGroup = 'Finance & Payroll';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('setting_key')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('setting_value')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('applies_to_role')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('setting_key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('setting_value')
                    ->searchable(),
                Tables\Columns\TextColumn::make('applies_to_role')
                    ->searchable(),
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
            'index' => Pages\ListPayrollSettings::route('/'),
            'create' => Pages\CreatePayrollSetting::route('/create'),
            'edit' => Pages\EditPayrollSetting::route('/{record}/edit'),
        ];
    }
}
