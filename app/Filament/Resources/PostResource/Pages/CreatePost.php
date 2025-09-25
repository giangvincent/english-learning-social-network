<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Repositories\ExportJson;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['pid'] = $data['pid'] ?: (string) Str::uuid();
        $data['author'] = $data['author'] ?: auth()->id();
        $data['subject'] = strip_tags($data['subject'] ?? '');
        $data['content'] = $this->sanitizeContent($data['content'] ?? '');

        return $data;
    }

    protected function afterCreate(): void
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
