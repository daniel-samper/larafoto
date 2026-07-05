<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    // Relación One To Many
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
