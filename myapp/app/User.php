<?php

namespace App;

use App\Traits\Friendable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    use Friendable;
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'picture_path'];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function friends()
    {
        return $this->hasMany('App\Friend');
    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
