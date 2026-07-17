<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    protected $fillable = ['image_id', 'user_id'];

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
