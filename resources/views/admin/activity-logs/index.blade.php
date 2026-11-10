@extends('admin.layouts.app')

@section('title', 'Activity Log')

@section('content')
    <h2 class="text-lg font-semibold mb-5">Admin Activity Log</h2>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-4 rounded-lg shadow-sm mb-6">
        <select name="admin_id" class="border border-gray-200 rounded-md px-3 py-2 text-sm">
            <option value="">All Admins</option>
            @foreach ($admins as $admin)
                <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                    {{ $admin->name }}</option>
            @endforeach
        </select>
        <select name="action" class="border border-gray-200 rounded-md px-3 py-2 text-sm">
            <option value="">All Actions</option>
            <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
            <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
            <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
        </select>
        <button type="submit" class="btn-primary text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-lg shadow-sm divide-y divide-gray-100">
        @forelse($logs as $log)
            <div class="flex items-center gap-3 px-5 py-3">
                <span class="text-lg">{{ $log->icon() }}</span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm">
                        <strong>{{ $log->admin?->name ?? 'System' }}</strong>
                        {{ $log->action }} a <strong>{{ $log->subject_type }}</strong>
                        @if ($log->subject_label)
                            — "{{ $log->subject_label }}"
                        @endif
                    </p>
                    <p class="text-xs text-gray-400">{{ $log->created_at->format('d M, Y h:i A') }} · IP:
                        {{ $log->ip_address }}</p>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-10">No activity recorded yet.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $logs->links() }}</div>
@endsection
