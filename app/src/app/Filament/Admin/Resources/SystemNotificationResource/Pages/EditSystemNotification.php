<?php

namespace App\Filament\Admin\Resources\SystemNotificationResource\Pages;

use App\Filament\Admin\Resources\SystemNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSystemNotification extends EditRecord
{
    protected static string $resource = SystemNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
