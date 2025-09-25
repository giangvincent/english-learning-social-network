<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use App\Repositories\ExportJson;
use App\Services\AdminContentExporter;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTag extends CreateRecord
{
    protected static string $resource = TagResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = Str::of($data['name'])->lower();
        $data['slug'] = AdminContentExporter::slugFrom($data['name']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $tag = $this->record->fresh();
        AdminContentExporter::syncTag($tag);
        AdminContentExporter::syncTagsFeed();
        ExportJson::feedToJson('home');
        ExportJson::feedToJson('category');
    }
}
