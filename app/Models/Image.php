<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $guarded = false;

    public function getUrlAttribute()
    {
        return url('storage/' . $this->path);
    }
}
