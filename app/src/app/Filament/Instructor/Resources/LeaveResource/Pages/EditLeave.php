<?php

namespace App\Filament\Instructor\Resources\LeaveResource\Pages;

use App\Filament\Instructor\Resources\LeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeave extends EditRecord
{
    protected static string $resource = LeaveResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth('instructor')->id(); // Set user_id secara eksplisit

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
