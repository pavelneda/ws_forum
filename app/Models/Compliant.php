<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compliant extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function theme()
    {
        return $this->hasOneThrough('App\Models\Theme', 'App\Models\Message', 'id', 'id', 'message_id', 'theme_id');
    }
}
