<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'bio', 'socials_conn', 'notification_conn', 'others', 'cover_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
