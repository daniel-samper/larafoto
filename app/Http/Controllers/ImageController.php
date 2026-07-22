<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

    /**
     * Display the specified image.
     */
    public function show(Image $image)
    {
        $image->load('comments.user');
        return view('images.detail', compact('image'));
    }

    /**
     * Show the form to edit an existing image.
     */
    public function edit(Image $image)
    {
        if ($image->user_id !== Auth::id()) {
            abort(403);
        }
        return view('images.edit', compact('image'));
    }

    /**
     * Update an existing image in storage.
     */
    public function update(Request $request, Image $image)
    {
        if ($image->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string|max:500',
        ]);

        // Update description
        $image->description = $validated['description'];

        // Handle new image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image file
            Storage::disk('public')->delete($image->image_path);

            // Upload new image
            $newImage = $request->file('image');
            $filename = time() . '_' . $newImage->getClientOriginalName();
            $path = $newImage->storeAs('uploads/images', $filename, 'public');

            $image->image_path = $path;
        }

        $image->save();

        return redirect()->route('images.show', $image->id)->with('success', 'Image updated successfully!');
    }

    /**
     * Remove the specified image from storage.
     */
    public function delete(Image $image)
    {
        // Authorization: only the owner can delete their image
        if ($image->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete related likes and comments
        DB::table('likes')->where('image_id', $image->id)->delete();
        DB::table('comments')->where('image_id', $image->id)->delete();

        // Delete the image file from storage
        Storage::disk('public')->delete($image->image_path);

        // Delete the image record
        $image->delete();

        return redirect()->route('images.index')->with('success', 'Image deleted successfully!');
    }
}
