@extends('admin.layouts.app')

@section('title', 'Live Queue Management')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Live Queue Management</h2>
        <a href="{{ route('queue.index') }}" target="_blank" class="btn-outline text-sm">📺 View Public Display</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Doctor</th>
                    <th class="p-3">Current Serial</th>
                    <th class="p-3">Active Today</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors as $doctor)
                    <tr class="border-t">
                        <td class="p-3">{{ $doctor->name }}</td>
                        <td class="p-3">
                            <form action="{{ route('admin.queue-displays.update', $doctor) }}" method="POST"
                                class="flex items-center gap-2">
                                @csrf @method('PUT')
                                <input type="text" name="current_serial"
                                    value="{{ $doctor->queueDisplay->current_serial ?? '' }}" placeholder="e.g. 12"
                                    class="w-24 border border-gray-200 rounded-md px-2 py-1.5 text-sm">
                                <label class="flex items-center gap-1 text-xs">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ $doctor->queueDisplay?->is_active ? 'checked' : '' }}>
                                    Active
                                </label>
                                <button type="submit" class="btn-primary text-xs px-3 py-1.5">Update</button>
                            </form>
                        </td>
                        <td class="p-3 text-gray-400 text-xs">
                            {{ $doctor->queueDisplay && $doctor->queueDisplay->queue_date?->isToday() ? 'Updated today' : 'Not updated today' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
