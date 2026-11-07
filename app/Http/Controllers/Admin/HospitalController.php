<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::latest()->paginate(20);

        return view('admin.hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        $hospital = new Hospital();

        return view('admin.hospitals.form', compact('hospital'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hospitals', 'public');
        }

        Hospital::create($data);

        return redirect()->route('admin.hospitals.index')->with('success', 'Hospital added successfully.');
    }

    public function edit(Hospital $hospital)
    {
        return view('admin.hospitals.form', compact('hospital'));
    }

    public function update(Request $request, Hospital $hospital)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($hospital->image) {
                Storage::disk('public')->delete($hospital->image);
            }
            $data['image'] = $request->file('image')->store('hospitals', 'public');
        }

        $hospital->update($data);

        return redirect()->route('admin.hospitals.index')->with('success', 'Hospital updated successfully.');
    }

    public function destroy(Hospital $hospital)
    {
        if ($hospital->image) {
            Storage::disk('public')->delete($hospital->image);
        }
        $hospital->delete();

        return back()->with('success', 'Hospital deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'description' => ['nullable', 'string'],
            'facilities' => ['nullable', 'string'],
            'map_embed' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
