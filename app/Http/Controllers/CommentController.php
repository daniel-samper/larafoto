<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'image_id' => 'required|exists:images,id',
            'comment' => 'required|string|max:500',
        ]);

        // Create the comment
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->image_id = $validated['image_id'];
        $comment->comment = $validated['comment'];
        $comment->save();

        // Redirect back to the image with success message
        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
