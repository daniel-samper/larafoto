<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['user_id', 'image_path', 'description'];

    // Relación One To Many
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}