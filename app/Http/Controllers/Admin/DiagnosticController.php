<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnostic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DiagnosticController extends Controller
{
    public function index()
    {
        $diagnostics = Diagnostic::latest()->paginate(20);

        return view('admin.diagnostics.index', compact('diagnostics'));
    }

    public function create()
    {
        $diagnostic = new Diagnostic();

        return view('admin.diagnostics.form', compact('diagnostic'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('diagnostics', 'public');
        }

        Diagnostic::create($data);

        return redirect()->route('admin.diagnostics.index')->with('success', 'Diagnostic center added successfully.');
    }

    public function edit(Diagnostic $diagnostic)
    {
        return view('admin.diagnostics.form', compact('diagnostic'));
    }

    public function update(Request $request, Diagnostic $diagnostic)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($diagnostic->image) {
                Storage::disk('public')->delete($diagnostic->image);
            }
            $data['image'] = $request->file('image')->store('diagnostics', 'public');
        }

        $diagnostic->update($data);

        return redirect()->route('admin.diagnostics.index')->with('success', 'Diagnostic center updated successfully.');
    }

    public function destroy(Diagnostic $diagnostic)
    {
        if ($diagnostic->image) {
            Storage::disk('public')->delete($diagnostic->image);
        }
        $diagnostic->delete();

        return back()->with('success', 'Diagnostic center deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'description' => ['nullable', 'string'],
            'tests_available' => ['nullable', 'string'],
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
