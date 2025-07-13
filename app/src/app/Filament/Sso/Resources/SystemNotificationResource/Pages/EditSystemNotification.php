<?php

namespace App\Filament\Sso\Resources\SystemNotificationResource\Pages;

use App\Filament\Sso\Resources\SystemNotificationResource;
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
