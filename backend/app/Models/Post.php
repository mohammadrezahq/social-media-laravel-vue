<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'item_id', '_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
