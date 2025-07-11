<?php

namespace App\Filament\Sso\Resources;

use App\Filament\Sso\Resources\CompanyProfileSettingResource\Pages;
use App\Filament\Sso\Resources\CompanyProfileSettingResource\RelationManagers;
use App\Models\CompanyProfileSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyProfileSettingResource extends Resource
{
    protected static ?string $model = CompanyProfileSetting::class;

    protected static ?string $navigationGroup = 'Organization Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('setting_key')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('setting_value')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('setting_key')
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
            'index' => Pages\ListCompanyProfileSettings::route('/'),
            'create' => Pages\CreateCompanyProfileSetting::route('/create'),
            'edit' => Pages\EditCompanyProfileSetting::route('/{record}/edit'),
        ];
    }
}
