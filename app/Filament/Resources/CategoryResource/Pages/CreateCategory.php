<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Services\AdminContentExporter;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = AdminContentExporter::slugFrom($data['name']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $category = $this->record;
        AdminContentExporter::syncCategory($category);
        AdminContentExporter::syncCategoriesFeed();
        AdminContentExporter::notifyPostUpdateForCategory($category->id);
    }
}
