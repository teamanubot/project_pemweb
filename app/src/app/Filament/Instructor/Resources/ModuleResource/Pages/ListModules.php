<?php

namespace App\Filament\Instructor\Resources\ModuleResource\Pages;

use App\Filament\Instructor\Resources\ModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModules extends ListRecords
{
    protected static string $resource = ModuleResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth('instructor')->id(); // Set user_id secara eksplisit

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
