<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::withCount('individualTests')->latest()->paginate(20);

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $package = new Package();
        $tests = Test::where('is_active', true)->orderBy('name')->get();

        return view('admin.packages.form', compact('package', 'tests'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        $package = Package::create($data);

        $package->individualTests()->sync($request->input('test_ids', []));

        return redirect()->route('admin.packages.index')->with('success', 'Package added successfully.');
    }

    public function edit(Package $package)
    {
        $tests = Test::where('is_active', true)->orderBy('name')->get();
        $package->load('individualTests');

        return view('admin.packages.form', compact('package', 'tests'));
    }

    public function update(Request $request, Package $package)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        $package->update($data);

        $package->individualTests()->sync($request->input('test_ids', []));

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }
        $package->individualTests()->detach();
        $package->delete();

        return back()->with('success', 'Package deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'tests' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);
    }
}
