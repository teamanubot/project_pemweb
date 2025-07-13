<?php

namespace App\Filament\Admin\Resources\CompanyProfileSettingResource\Pages;

use App\Filament\Admin\Resources\CompanyProfileSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyProfileSettings extends ListRecords
{
    protected static string $resource = CompanyProfileSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
