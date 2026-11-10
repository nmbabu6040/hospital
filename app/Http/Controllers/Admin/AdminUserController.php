<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = Admin::with('branch')->latest()->paginate(20);

        return view('admin.admin-users.index', compact('admins'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $adminUser = new Admin();

        return view('admin.admin-users.form', compact('branches', 'adminUser'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:super_admin,branch_admin,editor'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'is_active' => ['nullable', 'boolean'],
            'two_factor_enabled' => ['nullable', 'boolean'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);

        $data['two_factor_enabled'] = $request->boolean('two_factor_enabled');

        Admin::create($data);

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user added successfully.');
    }

    public function edit(Admin $adminUser)
    {
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('admin.admin-users.form', compact('adminUser', 'branches'));
    }

    public function update(Request $request, Admin $adminUser)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore($adminUser->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:super_admin,branch_admin,editor'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'is_active' => ['nullable', 'boolean'],
            'two_factor_enabled' => ['nullable', 'boolean'],
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $data['two_factor_enabled'] = $request->boolean('two_factor_enabled');

        $adminUser->update($data);

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user updated successfully.');
    }

    public function destroy(Admin $adminUser)
    {
        if ($adminUser->id === auth('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $adminUser->delete();

        return back()->with('success', 'Admin user deleted successfully.');
    }
}
