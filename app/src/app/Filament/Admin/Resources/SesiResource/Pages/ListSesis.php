<?php

namespace App\Filament\Admin\Resources\SesiResource\Pages;

use App\Filament\Admin\Resources\SesiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSesis extends ListRecords
{
    protected static string $resource = SesiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
