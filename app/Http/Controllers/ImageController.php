<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Show the form to create a new image.
     */
    public function create()
    {
        return view('images.create');
    }

    /**
     * Store a newly created image in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string|max:500',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();

            // Store in public/uploads/images (public disk)
            $path = $image->storeAs('uploads/images', $filename, 'public');

            Image::create([
                'user_id' => Auth::id(),
                'image_path' => $path,
                'description' => $request->input('description'),
            ]);

            return redirect()->back()->with('success', 'Image uploaded successfully!');
        }

        return back()->with('error', 'Please select an image to upload.');
    }

    /**
     * Display a listing of images.
     */
    public function index()
    {
        $images = Image::with('user')
            ->latest()
            ->paginate(3);

        return view('images.index', compact('images'));
    }
}
