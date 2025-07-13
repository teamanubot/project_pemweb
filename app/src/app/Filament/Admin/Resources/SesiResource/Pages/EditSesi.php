<?php

namespace App\Filament\Admin\Resources\SesiResource\Pages;

use App\Filament\Admin\Resources\SesiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSesi extends EditRecord
{
    protected static string $resource = SesiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
