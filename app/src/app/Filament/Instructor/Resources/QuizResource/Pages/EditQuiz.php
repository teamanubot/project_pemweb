<?php

namespace App\Filament\Instructor\Resources\QuizResource\Pages;

use App\Filament\Instructor\Resources\QuizResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuiz extends EditRecord
{
    protected static string $resource = QuizResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by_user_id'] = auth('instructor')->id();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
