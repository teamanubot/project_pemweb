<?php

namespace App\Filament\Instructor\Resources\ModuleResource\Pages;

use App\Filament\Instructor\Resources\ModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModule extends EditRecord
{
    protected static string $resource = ModuleResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uploaded_by_user_id'] = auth('instructor')->id();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
