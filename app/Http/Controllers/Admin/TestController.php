<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $query = Test::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tests = $query->latest()->paginate(25)->withQueryString();

        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        $test = new Test();

        return view('admin.tests.form', compact('test'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        Test::create($data);

        return redirect()->route('admin.tests.index')->with('success', 'Test added successfully.');
    }

    public function edit(Test $test)
    {
        return view('admin.tests.form', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        $data = $this->validateData($request);
        $test->update($data);

        return redirect()->route('admin.tests.index')->with('success', 'Test updated successfully.');
    }

    public function destroy(Test $test)
    {
        $test->delete();

        return back()->with('success', 'Test deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'sample_type' => ['nullable', 'string', 'max:255'],
            'report_time' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'preparation' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
