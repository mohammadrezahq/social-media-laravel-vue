<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Follow;

use Laravel\Sanctum\HasApiTokens;

class User extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    protected $connection = 'mongodb';
    protected $table = 'users';

    protected $fillable = [
        'username', 'display_name', 'password', 'email', 'profile', 'gender', 'bio', 'birthday'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $nullable = [
        'bio',
        'profile'
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', '_id')->orderBy('created_at', 'DESC');
    }

    public function followings()
    {
        return $this->hasMany(Follow::class, 'follower', '_id');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'followed', '_id');
    }
}
