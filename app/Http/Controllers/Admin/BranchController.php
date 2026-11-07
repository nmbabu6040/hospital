<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->paginate(20);

        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        $branch = new Branch();

        return view('admin.branches.form', compact('branch'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        Branch::create($data);

        return redirect()->route('admin.branches.index')->with('success', 'Branch added successfully.');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.form', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $data = $this->validateData($request);
        $branch->update($data);

        return redirect()->route('admin.branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        if ($branch->admins()->count() > 0 || $branch->doctors()->count() > 0) {
            return back()->with('error', 'Cannot delete a branch that has admins or doctors assigned to it.');
        }

        $branch->delete();

        return back()->with('success', 'Branch deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
