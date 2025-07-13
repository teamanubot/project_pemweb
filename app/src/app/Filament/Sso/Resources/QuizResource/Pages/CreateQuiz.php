<?php

namespace App\Filament\Sso\Resources\QuizResource\Pages;

use App\Filament\Sso\Resources\QuizResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuiz extends CreateRecord
{
    protected static string $resource = QuizResource::class;
}
