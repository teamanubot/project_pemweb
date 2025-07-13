<?php

namespace App\Filament\Sso\Resources;

use App\Filament\Sso\Resources\PaymentTransactionResource\Pages;
use App\Filament\Sso\Resources\PaymentTransactionResource\RelationManagers;
use App\Models\PaymentTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentTransactionResource extends Resource
{
    protected static ?string $model = PaymentTransaction::class;

    protected static ?string $navigationGroup = 'Finance & Payroll';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->options(function () {
                        $user = auth('student')->user();
                        return $user ? [$user->id => $user->name] : [];
                    })
                    ->default(auth('student')->id())
                    ->disabled()
                    ->required()
                    ->dehydrated(),
                Forms\Components\Select::make('course_enrollment_id')
                    ->relationship('courseEnrollment', 'id')
                    ->required(),
                Forms\Components\TextInput::make('midtrans_order_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('midtrans_transaction_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('currency')
                    ->required()
                    ->maxLength(255)
                    ->default('IDR'),
                Forms\Components\TextInput::make('payment_method')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('transaction_status')
                    ->required(),
                Forms\Components\DateTimePicker::make('transaction_time')
                    ->required(),
                Forms\Components\DateTimePicker::make('settlement_time'),
                Forms\Components\DateTimePicker::make('expiry_time'),
                Forms\Components\Textarea::make('raw_response')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('courseEnrollment.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('midtrans_order_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('midtrans_transaction_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction_status'),
                Tables\Columns\TextColumn::make('transaction_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('settlement_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_time')
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
            'index' => Pages\ListPaymentTransactions::route('/'),
            'create' => Pages\CreatePaymentTransaction::route('/create'),
            'edit' => Pages\EditPaymentTransaction::route('/{record}/edit'),
        ];
    }
}
