<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SisterConcern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SisterConcernController extends Controller
{
    public function index()
    {
        $concerns = SisterConcern::latest()->paginate(20);

        return view('admin.sister-concerns.index', compact('concerns'));
    }

    public function create()
    {
        $concern = new SisterConcern();

        return view('admin.sister-concerns.form', compact('concern'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('sister-concerns', 'public');
        }

        SisterConcern::create($data);

        return redirect()->route('admin.sister-concerns.index')->with('success', 'Sister Concern added successfully.');
    }

    public function edit(SisterConcern $sisterConcern)
    {
        return view('admin.sister-concerns.form', ['concern' => $sisterConcern]);
    }

    public function update(Request $request, SisterConcern $sisterConcern)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('logo')) {
            if ($sisterConcern->logo) {
                Storage::disk('public')->delete($sisterConcern->logo);
            }
            $data['logo'] = $request->file('logo')->store('sister-concerns', 'public');
        }

        $sisterConcern->update($data);

        return redirect()->route('admin.sister-concerns.index')->with('success', 'Sister Concern updated successfully.');
    }

    public function destroy(SisterConcern $sisterConcern)
    {
        if ($sisterConcern->logo) {
            Storage::disk('public')->delete($sisterConcern->logo);
        }
        $sisterConcern->delete();

        return back()->with('success', 'Sister Concern deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
