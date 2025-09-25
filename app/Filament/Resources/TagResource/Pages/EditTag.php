<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use App\Repositories\ExportJson;
use App\Services\AdminContentExporter;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditTag extends EditRecord
{
    protected static string $resource = TagResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = Str::of($data['name'])->lower();
        $data['slug'] = AdminContentExporter::slugFrom($data['name']);

        return $data;
    }

    protected function afterSave(): void
    {
        $tag = $this->record->fresh();
        AdminContentExporter::syncTag($tag);
        AdminContentExporter::syncTagsFeed();
        ExportJson::feedToJson('home');
        ExportJson::feedToJson('category');
    }
}
