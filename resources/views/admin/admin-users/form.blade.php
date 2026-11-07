@extends('admin.layouts.app')

@section('title', $adminUser->exists ? 'Edit Admin User' : 'Add Admin User')

@section('content')
    <form
        action="{{ $adminUser->exists ? route('admin.admin-users.update', $adminUser) : route('admin.admin-users.store') }}"
        method="POST" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-xl">
        @csrf
        @if ($adminUser->exists)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $adminUser->name) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email', $adminUser->email) }}" required
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password
                {{ $adminUser->exists ? '(ফাঁকা রাখলে পুরনো password থাকবে)' : '*' }}</label>
            <input type="password" name="password" {{ $adminUser->exists ? '' : 'required' }}
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Role <span class="text-red-500">*</span></label>
            <select name="role" id="role-select" required class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                <option value="editor" {{ old('role', $adminUser->role) == 'editor' ? 'selected' : '' }}>Editor (content
                    only, no delete)</option>
                <option value="branch_admin" {{ old('role', $adminUser->role) == 'branch_admin' ? 'selected' : '' }}>Branch
                    Admin (manages own branch)</option>
                <option value="super_admin" {{ old('role', $adminUser->role) == 'super_admin' ? 'selected' : '' }}>Super
                    Admin (full access)</option>
            </select>
        </div>

        <div id="branch-field">
            <label class="block text-sm font-medium mb-1">Branch (Branch Admin হলে আবশ্যক)</label>
            <select name="branch_id" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                <option value="">-- Select Branch --</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}"
                        {{ old('branch_id', $adminUser->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $adminUser->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>

        <button type="submit" class="btn-primary">Save</button>
    </form>

    <script>
        const roleSelect = document.getElementById('role-select');
        const branchField = document.getElementById('branch-field');

        function toggleBranchField() {
            branchField.style.display = roleSelect.value === 'branch_admin' ? 'block' : 'none';
        }
        toggleBranchField();
        roleSelect.addEventListener('change', toggleBranchField);
    </script>
@endsection
