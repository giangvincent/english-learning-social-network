<?php

namespace App\Services;

use App\Jobs\UpdatePostWhenDbChange;
use App\Models\Category;
use App\Models\StaticContent;
use App\Models\Tag;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminContentExporter
{
    public static function syncCategory(Category $category): void
    {
        self::ensureDirectory(public_path('dist/content/categories'));
        File::put(
            public_path('dist/content/categories/' . $category->slug . '.json'),
            json_encode($category->toArray())
        );
    }

    public static function syncCategoriesFeed(): void
    {
        self::ensureDirectory(public_path('dist/content'));
        $allCats = Category::where('status', 'publish')->get();
        $allCatsData = [];
        foreach ($allCats as $cat) {
            $catData = $cat->toArray();
            $catData['posts'] = $cat->posts()->count();
            $allCatsData[] = $catData;
        }

        File::put(public_path('dist/content/categories.json'), json_encode($allCatsData));
    }

    public static function notifyPostUpdateForCategory(int $categoryId): void
    {
        UpdatePostWhenDbChange::dispatch('category', $categoryId);
    }

    public static function syncTag(Tag $tag): void
    {
        self::ensureDirectory(public_path('content/tags'));
        File::put(public_path('content/tags/' . $tag->slug . '.json'), json_encode($tag->toArray()));
    }

    public static function syncTagsFeed(): void
    {
        self::ensureDirectory(public_path('content'));
        $allTags = Tag::where('status', 'publish')->get();
        $allTagsData = [];
        foreach ($allTags as $tag) {
            $tagData = $tag->toArray();
            $tagData['posts'] = $tag->posts()->count();
            $allTagsData[] = $tagData;
        }

        File::put(public_path('content/tags.json'), json_encode($allTagsData));
    }

    public static function syncStaticContent(StaticContent $content): void
    {
        self::ensureDirectory(public_path('dist/content'));
        $payload = [
            'title' => $content->title,
            'content' => $content->content,
        ];

        File::put(public_path('dist/content/' . $content->type . '.json'), json_encode($payload));
    }

    public static function ensureDirectory(string $path): void
    {
        if (File::isDirectory($path)) {
            return;
        }

        File::makeDirectory($path, recursive: true);
    }

    public static function slugFrom(string $value): string
    {
        return Str::slug($value, '-');
    }
}
