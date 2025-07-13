<?php

namespace App\Filament\Instructor\Resources\SubmissionResource\Pages;

use App\Filament\Instructor\Resources\SubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubmission extends EditRecord
{
    protected static string $resource = SubmissionResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['graded_by_user_id'] = auth('instructor')->id();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
