<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('sort_order')->paginate(20);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $department = new Department();

        return view('admin.departments.form', compact('department'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('departments', 'public');
        }

        Department::create($data);

        return redirect()->route('admin.departments.index')->with('success', 'Department added successfully.');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.form', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($department->image) {
                Storage::disk('public')->delete($department->image);
            }
            $data['image'] = $request->file('image')->store('departments', 'public');
        }

        $department->update($data);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        if ($department->image) {
            Storage::disk('public')->delete($department->image);
        }
        $department->delete();

        return back()->with('success', 'Department deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'services' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['nullable', 'integer'],
            'is_featured' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]) + ['is_featured' => $request->boolean('is_featured'), 'sort_order' => $request->input('sort_order', 0)];
    }
}
