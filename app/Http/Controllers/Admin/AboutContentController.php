<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutContentController extends Controller
{
    public function edit()
    {
        $aboutContent = AboutContent::get();

        return view('admin.about-content.edit', compact('aboutContent'));
    }

    public function update(Request $request)
    {
        $aboutContent = AboutContent::get();

        $data = $request->validate([
            'md_name' => ['nullable', 'string', 'max:255'],
            'md_designation' => ['nullable', 'string', 'max:255'],
            'md_message' => ['nullable', 'string'],
            'md_image' => ['nullable', 'image', 'max:2048'],
            'about_text' => ['nullable', 'string'],
            'about_image' => ['nullable', 'image', 'max:2048'],
            'patients_count' => ['nullable', 'integer', 'min:0'],
            'staff_count' => ['nullable', 'integer', 'min:0'],
            'doctors_count' => ['nullable', 'integer', 'min:0'],
        ]);

        foreach (['md_image', 'about_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($aboutContent->$field) {
                    Storage::disk('public')->delete($aboutContent->$field);
                }
                $data[$field] = $request->file($field)->store('about', 'public');
            }
        }

        if ($aboutContent->exists) {
            $aboutContent->update($data);
        } else {
            AboutContent::create($data);
        }

        return back()->with('success', 'About content updated successfully.');
    }
}
