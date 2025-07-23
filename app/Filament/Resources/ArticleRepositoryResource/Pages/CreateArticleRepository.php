<?php

namespace App\Filament\Resources\ArticleRepositoryResource\Pages;

use App\Filament\Resources\ArticleRepositoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticleRepository extends CreateRecord
{
    protected static string $resource = ArticleRepositoryResource::class;
}
