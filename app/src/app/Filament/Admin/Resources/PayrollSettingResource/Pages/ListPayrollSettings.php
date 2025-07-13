<?php

namespace App\Filament\Admin\Resources\PayrollSettingResource\Pages;

use App\Filament\Admin\Resources\PayrollSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayrollSettings extends ListRecords
{
    protected static string $resource = PayrollSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
