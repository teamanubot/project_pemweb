<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\LeaveResource\Pages;
use App\Filament\Instructor\Resources\LeaveResource\RelationManagers;
use App\Models\Leave;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationGroup = 'Student Affairs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->default(auth('instructor')->id())
                    ->relationship('user', 'name')
                    ->disabled(),
                Forms\Components\TextInput::make('leave_type')
                    ->required(),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->required(),
                Forms\Components\TextInput::make('number_of_days')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('proof_file_path')
                    ->label('Surat Bukti/Izin')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('status')
                    ->label('Leave Status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->hidden(),
                Forms\Components\TextInput::make('approved_by_user_id')
                    ->numeric()
                    ->default(null)
                    ->hidden(), 
                Forms\Components\DateTimePicker::make('approved_at')
                    ->default(null)
                    ->hidden(),
                Forms\Components\TextInput::make('replacement_user_id')
                    ->numeric()
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
                Tables\Columns\TextColumn::make('leave_type'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_of_days')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('proof_file_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('approved_by_user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('replacement_user_id')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaves::route('/'),
            'create' => Pages\CreateLeave::route('/create'),
            'edit' => Pages\EditLeave::route('/{record}/edit'),
        ];
    }
}
