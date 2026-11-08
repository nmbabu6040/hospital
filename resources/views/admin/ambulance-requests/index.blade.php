@extends('admin.layouts.app')

@section('title', 'Ambulance Requests')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h2 class="text-lg font-semibold">Ambulance Requests</h2>
        <div class="flex gap-2 text-sm">
            <a href="{{ route('admin.ambulance-requests.index') }}"
                class="px-3 py-1.5 rounded-md {{ !request('status') ? 'bg-brand text-white' : 'bg-gray-100' }}">All</a>
            <a href="{{ route('admin.ambulance-requests.index', ['status' => 'pending']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'pending' ? 'bg-amber-500 text-white' : 'bg-gray-100' }}">Pending</a>
            <a href="{{ route('admin.ambulance-requests.index', ['status' => 'assigned']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'assigned' ? 'bg-blue-500 text-white' : 'bg-gray-100' }}">Assigned</a>
            <a href="{{ route('admin.ambulance-requests.index', ['status' => 'completed']) }}"
                class="px-3 py-1.5 rounded-md {{ request('status') == 'completed' ? 'bg-green-500 text-white' : 'bg-gray-100' }}">Completed</a>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($requests as $request)
            <div class="bg-white rounded-lg shadow-sm p-5 {{ $request->is_emergency ? 'border-l-4 border-red-500' : '' }}">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            @if ($request->is_emergency)
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">🚨
                                    EMERGENCY</span>
                            @endif
                            <p class="font-semibold text-sm">{{ $request->requester_name }}</p>
                            <span class="text-xs text-gray-400">{{ $request->phone }}</span>
                        </div>
                        <p class="text-sm text-gray-600"><strong>Pickup:</strong> {{ $request->pickup_location }}</p>
                        @if ($request->drop_location)
                            <p class="text-sm text-gray-600"><strong>Drop:</strong> {{ $request->drop_location }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">Type: {{ $request->ambulance_type }} ·
                            {{ $request->created_at->diffForHumans() }}</p>
                        @if ($request->additional_info)
                            <p class="text-xs text-gray-500 mt-1">{{ $request->additional_info }}</p>
                        @endif
                    </div>

                    <form action="{{ route('admin.ambulance-requests.update', $request) }}" method="POST"
                        class="flex flex-wrap items-center gap-2 text-sm">
                        @csrf @method('PUT')
                        <select name="ambulance_id" class="border border-gray-200 rounded-md px-2 py-1.5 text-xs">
                            <option value="">-- Assign Ambulance --</option>
                            @foreach ($availableAmbulances as $ambulance)
                                <option value="{{ $ambulance->id }}"
                                    {{ $request->ambulance_id == $ambulance->id ? 'selected' : '' }}>
                                    {{ $ambulance->vehicle_no }} ({{ $ambulance->type }})</option>
                            @endforeach
                        </select>
                        <select name="status" class="border border-gray-200 rounded-md px-2 py-1.5 text-xs">
                            <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="assigned" {{ $request->status == 'assigned' ? 'selected' : '' }}>Assigned
                            </option>
                            <option value="on_the_way" {{ $request->status == 'on_the_way' ? 'selected' : '' }}>On the Way
                            </option>
                            <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ $request->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                        <button type="submit" class="btn-primary text-xs px-3 py-1.5">Update</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-10">No ambulance requests found.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $requests->links() }}</div>
@endsection
