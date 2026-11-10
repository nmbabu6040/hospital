<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    public function index()
    {
        $query = Doctor::with(['department', 'hospital', 'branch']);
        $admin = auth('admin')->user();

        if ($admin->isBranchAdmin() && $admin->branch_id) {
            $query->where('branch_id', $admin->branch_id);
        }

        $doctors = $query->latest()->paginate(20);

        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $hospitals = Hospital::orderBy('name')->get();
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $doctor = new Doctor();

        return view('admin.doctors.form', compact('departments', 'hospitals', 'branches', 'doctor'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('doctors', 'public');
        }

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        $admin = auth('admin')->user();
        if ($admin->isBranchAdmin() && $admin->branch_id) {
            $data['branch_id'] = $admin->branch_id;
        }

        if (! empty($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        Doctor::create($data);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function edit(Doctor $doctor)
    {
        $this->authorizeBranchAccess($doctor);

        $departments = Department::orderBy('name')->get();
        $hospitals = Hospital::orderBy('name')->get();
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('admin.doctors.form', compact('doctor', 'departments', 'hospitals', 'branches'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $this->authorizeBranchAccess($doctor);

        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            if ($doctor->image) {
                Storage::disk('public')->delete($doctor->image);
            }
            $data['image'] = $request->file('image')->store('doctors', 'public');
        }

        $admin = auth('admin')->user();
        if ($admin->isBranchAdmin() && $admin->branch_id) {
            $data['branch_id'] = $admin->branch_id;
        }

        if (! empty($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $doctor->update($data);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $this->authorizeBranchAccess($doctor);

        $admin = auth('admin')->user();
        if (! $admin->canDelete()) {
            abort(403, 'Editors are not allowed to delete records.');
        }

        if ($doctor->image) {
            Storage::disk('public')->delete($doctor->image);
        }
        $doctor->delete();

        return back()->with('success', 'Doctor deleted successfully.');
    }

    /**
     * Branch Admin যেন অন্য branch-এর ডাক্তার edit/delete করতে না পারে
     */
    private function authorizeBranchAccess(Doctor $doctor): void
    {
        $admin = auth('admin')->user();

        if ($admin->isBranchAdmin() && $admin->branch_id && $doctor->branch_id !== $admin->branch_id) {
            abort(403, 'You can only manage doctors from your own branch.');
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'degree' => ['nullable', 'string', 'max:255'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'hospital_id' => ['nullable', 'exists:hospitals,id'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'chamber_time' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'email' => ['nullable', 'email', 'unique:doctors,email' . ($request->route('doctor') ? ',' . $request->route('doctor')->id : '')],
            'password' => ['nullable', 'string', 'min:6'],
            'is_active' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
