<?php

namespace App\Filament\Sso\Resources\BlogPostResource\Pages;

use App\Filament\Sso\Resources\BlogPostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogPost extends CreateRecord
{
    protected static string $resource = BlogPostResource::class;
}
