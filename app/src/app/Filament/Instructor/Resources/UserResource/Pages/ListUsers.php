<?php

namespace App\Filament\Instructor\Resources\UserResource\Pages;

use App\Filament\Instructor\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Profile';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
