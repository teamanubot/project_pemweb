<?php

namespace App\Filament\Sso\Resources\CompanyProfileSettingResource\Pages;

use App\Filament\Sso\Resources\CompanyProfileSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyProfileSetting extends EditRecord
{
    protected static string $resource = CompanyProfileSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
