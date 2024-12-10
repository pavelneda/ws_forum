<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $guarded = false;
    protected $with = ['user:id,name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
