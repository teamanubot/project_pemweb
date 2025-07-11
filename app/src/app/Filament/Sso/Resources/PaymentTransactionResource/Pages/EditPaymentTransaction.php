<?php

namespace App\Filament\Sso\Resources\PaymentTransactionResource\Pages;

use App\Filament\Sso\Resources\PaymentTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentTransaction extends EditRecord
{
    protected static string $resource = PaymentTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
