<?php

namespace App\Filament\Instructor\Resources\SesiResource\Pages;

use App\Filament\Instructor\Resources\SesiResource;
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
