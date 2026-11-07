<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Gallery::latest()->paginate(24);

        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        $image = new Gallery();

        return view('admin.gallery.form', compact('image'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $data['image'] = $request->file('image')->store('gallery', 'public');

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Image added successfully.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.form', ['image' => $gallery]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image);
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Image updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
