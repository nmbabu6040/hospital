@extends('admin.layouts.app')

@section('title', 'Admin Users')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">Admin Users</h2>
        <a href="{{ route('admin.admin-users.create') }}" class="btn-primary">+ Add Admin User</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Branch</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $adminUser)
                    <tr class="border-t">
                        <td class="p-3">{{ $adminUser->name }} @if ($adminUser->id === auth('admin')->id())
                                <span class="text-xs text-gray-400">(You)</span>
                            @endif
                        </td>
                        <td class="p-3">{{ $adminUser->email }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs
                            {{ $adminUser->role == 'super_admin' ? 'bg-purple-100 text-purple-700' : ($adminUser->role == 'branch_admin' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                {{ $adminUser->roleLabel() }}
                            </span>
                        </td>
                        <td class="p-3">{{ $adminUser->branch?->name ?? '—' }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $adminUser->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                {{ $adminUser->is_active ? 'Active' : 'Disabled' }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.admin-users.edit', $adminUser) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            @if ($adminUser->id !== auth('admin')->id())
                                <form action="{{ route('admin.admin-users.destroy', $adminUser) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Delete this admin user?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-5 text-center text-gray-500">No admin users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $admins->links() }}</div>
@endsection
