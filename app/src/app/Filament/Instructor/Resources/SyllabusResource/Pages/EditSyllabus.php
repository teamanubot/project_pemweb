<?php

namespace App\Filament\Instructor\Resources\SyllabusResource\Pages;

use App\Filament\Instructor\Resources\SyllabusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSyllabus extends EditRecord
{
    protected static string $resource = SyllabusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
