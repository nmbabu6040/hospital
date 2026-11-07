@extends('admin.layouts.app')

@section('title', $hospitalStat->exists ? 'Edit Statistics Entry' : 'Add Statistics Entry')

@section('content')
    <form
        action="{{ $hospitalStat->exists ? route('admin.hospital-stats.update', $hospitalStat) : route('admin.hospital-stats.store') }}"
        method="POST" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @if ($hospitalStat->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Date <span class="text-red-500">*</span></label>
                <input type="date" name="stat_date"
                    value="{{ old('stat_date', $hospitalStat->stat_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                    required class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Hospital</label>
                <select name="hospital_id" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="">All Hospitals Combined</option>
                    @foreach ($hospitals as $hospital)
                        <option value="{{ $hospital->id }}"
                            {{ old('hospital_id', $hospitalStat->hospital_id) == $hospital->id ? 'selected' : '' }}>
                            {{ $hospital->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if (auth('admin')->user()->isSuperAdmin())
            <div>
                <label class="block text-sm font-medium mb-1">Branch</label>
                <select name="branch_id" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="">-- None --</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}"
                            {{ old('branch_id', $hospitalStat->branch_id) == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        @else
            <input type="hidden" name="branch_id" value="{{ auth('admin')->user()->branch_id }}">
        @endif

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-2">Patient Counts</h3>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Patients Admitted <span class="text-red-500">*</span></label>
                <input type="number" name="patients_admitted"
                    value="{{ old('patients_admitted', $hospitalStat->patients_admitted ?? 0) }}" required min="0"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Patients Discharged <span
                        class="text-red-500">*</span></label>
                <input type="number" name="patients_discharged"
                    value="{{ old('patients_discharged', $hospitalStat->patients_discharged ?? 0) }}" required
                    min="0" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Test-Only Patients <span class="text-red-500">*</span></label>
                <input type="number" name="test_only_patients"
                    value="{{ old('test_only_patients', $hospitalStat->test_only_patients ?? 0) }}" required min="0"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                <p class="text-xs text-gray-400 mt-1">যারা শুধু টেস্ট/ডায়াগনস্টিক করিয়ে চলে গেছেন।</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">OPD Patients <span class="text-red-500">*</span></label>
                <input type="number" name="opd_patients"
                    value="{{ old('opd_patients', $hospitalStat->opd_patients ?? 0) }}" required min="0"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Emergency Patients <span class="text-red-500">*</span></label>
            <input type="number" name="emergency_patients"
                value="{{ old('emergency_patients', $hospitalStat->emergency_patients ?? 0) }}" required min="0"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Notes (ঐচ্ছিক)</label>
            <textarea name="notes" rows="2" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('notes', $hospitalStat->notes) }}</textarea>
        </div>

        <button type="submit" class="btn-primary">Save</button>
    </form>
@endsection
