<?php

namespace App\Filament\Sso\Resources\SubmissionResource\Pages;

use App\Filament\Sso\Resources\SubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubmission extends EditRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
