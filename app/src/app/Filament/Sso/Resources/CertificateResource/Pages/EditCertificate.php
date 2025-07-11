<?php

namespace App\Filament\Sso\Resources\CertificateResource\Pages;

use App\Filament\Sso\Resources\CertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificate extends EditRecord
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
