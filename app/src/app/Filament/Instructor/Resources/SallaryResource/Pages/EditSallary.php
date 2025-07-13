<?php

namespace App\Filament\Instructor\Resources\SallaryResource\Pages;

use App\Filament\Instructor\Resources\SallaryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSallary extends EditRecord
{
    protected static string $resource = SallaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
