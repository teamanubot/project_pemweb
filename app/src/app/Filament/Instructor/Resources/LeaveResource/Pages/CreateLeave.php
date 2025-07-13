<?php

namespace App\Filament\Instructor\Resources\LeaveResource\Pages;

use App\Filament\Instructor\Resources\LeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLeave extends CreateRecord
{
    protected static string $resource = LeaveResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth('instructor')->id(); // Set user_id secara eksplisit

        return $data;
    }
}
