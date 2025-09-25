<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Repositories\ExportJson;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['subject'] = strip_tags($data['subject'] ?? '');
        $data['content'] = $this->sanitizeContent($data['content'] ?? '');

        return $data;
    }

    protected function afterSave(): void
    {
        $post = $this->record->fresh(['tags', 'user', 'categoryRelated']);
        ExportJson::exportPost($post);
        ExportJson::feedToJson('home');
        ExportJson::feedToJson('category');
    }

    protected function sanitizeContent(?string $content): ?string
    {
        if (blank($content)) {
            return $content;
        }

        return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
    }
}
