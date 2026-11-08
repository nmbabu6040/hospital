@extends('admin.layouts.app')

@section('title', 'Manage Consultation')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6 max-w-xl space-y-5">

        <div class="text-sm space-y-1 border-b pb-4">
            <p><strong>Patient:</strong> {{ $videoConsultation->patient_name }}</p>
            <p><strong>Phone:</strong> {{ $videoConsultation->phone }}</p>
            <p><strong>Doctor:</strong> {{ $videoConsultation->doctor?->name ?? 'Any' }}</p>
            <p><strong>Preferred:</strong> {{ $videoConsultation->preferred_date->format('d M, Y') }} —
                {{ $videoConsultation->preferred_time }}</p>
            @if ($videoConsultation->reason)
                <p><strong>Reason:</strong> {{ $videoConsultation->reason }}</p>
            @endif
        </div>

        @if ($videoConsultation->meeting_room_id)
            <div class="bg-blue-50 rounded-md p-3 text-sm">
                <strong>Meeting Link:</strong><br>
                <a href="{{ $videoConsultation->meetingUrl() }}" target="_blank"
                    class="text-blue-600 hover:underline break-all">{{ $videoConsultation->meetingUrl() }}</a>
            </div>
        @endif

        <form action="{{ route('admin.video-consultations.update', $videoConsultation) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="pending" {{ $videoConsultation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="scheduled" {{ $videoConsultation->status == 'scheduled' ? 'selected' : '' }}>Scheduled
                        (ক্লিক করলে Meeting Link অটো তৈরি হবে)</option>
                    <option value="completed" {{ $videoConsultation->status == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                    <option value="cancelled" {{ $videoConsultation->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Scheduled Date & Time</label>
                <input type="datetime-local" name="scheduled_at"
                    value="{{ $videoConsultation->scheduled_at?->format('Y-m-d\TH:i') }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Admin Note</label>
                <textarea name="admin_note" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ $videoConsultation->admin_note }}</textarea>
            </div>

            <button type="submit" class="btn-primary">Update</button>
        </form>
    </div>
@endsection
