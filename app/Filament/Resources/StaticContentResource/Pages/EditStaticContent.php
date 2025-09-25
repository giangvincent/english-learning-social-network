<?php

namespace App\Filament\Resources\StaticContentResource\Pages;

use App\Filament\Resources\StaticContentResource;
use App\Services\AdminContentExporter;
use Filament\Resources\Pages\EditRecord;

class EditStaticContent extends EditRecord
{
    protected static string $resource = StaticContentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = AdminContentExporter::slugFrom($data['title']);

        return $data;
    }

    protected function afterSave(): void
    {
        $content = $this->record->fresh();
        AdminContentExporter::syncStaticContent($content);
    }
}
