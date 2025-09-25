<?php

namespace App\Filament\Resources\StaticContentResource\Pages;

use App\Filament\Resources\StaticContentResource;
use App\Services\AdminContentExporter;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateStaticContent extends CreateRecord
{
    protected static string $resource = StaticContentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = AdminContentExporter::slugFrom($data['title']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $content = $this->record->fresh();
        AdminContentExporter::syncStaticContent($content);
    }
}
