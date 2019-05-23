<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = ['requester', 'user_requested', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
