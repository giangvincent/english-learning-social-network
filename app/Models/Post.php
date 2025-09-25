<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'pid',
        'status',
        'subject',
        'content',
        'answer_list',
        'type',
        'author',
        'category',
        'nums_bagged',
        'nums_good',
        'nums_bad',
        'nums_share',
        'nums_comment',
    ];

    protected $casts = [
        'content' => 'string',
        'nums_bagged' => 'integer',
        'nums_good' => 'integer',
        'nums_bad' => 'integer',
        'nums_share' => 'integer',
        'nums_comment' => 'integer',
    ];
    public function categoryRelated()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function interacts()
    {
        return $this->hasMany(userInteract::class);
    }

    public function answers()
    {
        return $this->hasMany(postAnswer::class);
    }

    public function comments()
    {
        return $this->hasMany(postComment::class);
    }
    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

}
