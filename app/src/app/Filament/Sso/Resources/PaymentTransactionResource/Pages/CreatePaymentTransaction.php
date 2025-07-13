<?php

namespace App\Filament\Sso\Resources\PaymentTransactionResource\Pages;

use App\Filament\Sso\Resources\PaymentTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentTransaction extends CreateRecord
{
    protected static string $resource = PaymentTransactionResource::class;
}
