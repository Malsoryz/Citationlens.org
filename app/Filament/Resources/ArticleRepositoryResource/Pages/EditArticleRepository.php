<?php

namespace App\Filament\Resources\ArticleRepositoryResource\Pages;

use App\Filament\Resources\ArticleRepositoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticleRepository extends EditRecord
{
    protected static string $resource = ArticleRepositoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
