<?php

namespace App\Filament\Instructor\Resources\QuizResource\Pages;

use App\Filament\Instructor\Resources\QuizResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuiz extends CreateRecord
{
    protected static string $resource = QuizResource::class;
}
