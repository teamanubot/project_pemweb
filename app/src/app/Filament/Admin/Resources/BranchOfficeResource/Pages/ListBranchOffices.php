<?php

namespace App\Filament\Admin\Resources\BranchOfficeResource\Pages;

use App\Filament\Admin\Resources\BranchOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBranchOffices extends ListRecords
{
    protected static string $resource = BranchOfficeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
