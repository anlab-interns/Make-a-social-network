<?php

namespace App;

use App\Traits\Friendable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    use Friendable;
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
}
