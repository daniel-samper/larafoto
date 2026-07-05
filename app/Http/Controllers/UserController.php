<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function config()
    {
        return view('user.config');
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        if (! $user instanceof User) {
            abort(403);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Upload user's image if provided
        $image_path = $request->file('image');
        if ($image_path) {
            // Unique name for the image
            $imageName = time() . '_' . $image_path->getClientOriginalName();
            // Store the image in the 'users' disk
            $image_path->storeAs('/', $imageName, 'users');
            // Set image0s name in object to save in database
            $user->image = $imageName;
        }
        
        // Update the user's information
        $user->update($validatedData);

        return redirect()->route('user.config')->with('success', 'User information updated successfully.');
    }

    public function getImage($filename)
    {
        $path = storage_path('app/users/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
