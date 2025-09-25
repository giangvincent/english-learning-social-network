<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Services\AdminContentExporter;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = AdminContentExporter::slugFrom($data['name']);

        return $data;
    }

    protected function afterSave(): void
    {
        $category = $this->record->fresh();
        AdminContentExporter::syncCategory($category);
        AdminContentExporter::syncCategoriesFeed();
        AdminContentExporter::notifyPostUpdateForCategory($category->id);
    }
}
