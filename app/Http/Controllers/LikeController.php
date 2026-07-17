<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Like a picture
     */
    public function like(Request $request, Image $image)
    {
        // Check if user has already liked this image
        $existingLike = Like::where('image_id', $image->id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$existingLike) {
            Like::create([
                'image_id' => $image->id,
                'user_id' => Auth::id(),
            ]);
        }

        // Return updated like count and like status
        return response()->json([
            'likes_count' => $image->likes()->count(),
            'is_liked' => true,
        ]);
    }

    /**
     * Dislike a picture (remove like)
     */
    public function dislike(Request $request, Image $image)
    {
        // Remove existing like
        Like::where('image_id', $image->id)
            ->where('user_id', Auth::id())
            ->delete();

        // Return updated like count and like status
        return response()->json([
            'likes_count' => $image->likes()->count(),
            'is_liked' => false,
        ]);
    }
}
