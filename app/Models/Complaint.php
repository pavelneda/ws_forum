<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $guarded = false;
    protected $table = 'compliants';
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function theme()
    {
        return $this->hasOneThrough('App\Models\Theme', 'App\Models\Message', 'id', 'id', 'message_id', 'theme_id');
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }
}
