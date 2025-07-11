<?php

namespace App\Filament\Instructor\Resources\LeaveResource\Pages;

use App\Filament\Instructor\Resources\LeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaves extends ListRecords
{
    protected static string $resource = LeaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
