<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover',
        'parent',
        'status',
    ];

    protected $casts = [
        'parent' => 'integer',
    ];

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent');
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'category');
    }
}
