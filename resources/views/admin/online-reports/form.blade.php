@extends('admin.layouts.app')

@section('title', $report->exists ? 'Edit Report' : 'Add Report')

@section('content')
    <form
        action="{{ $report->exists ? route('admin.online-reports.update', $report) : route('admin.online-reports.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-3xl"
        x-data="reportItemsForm()">
        @csrf
        @if ($report->exists)
            @method('PUT')
        @endif

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4">Patient Information</h3>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Patient Name <span class="text-red-500">*</span></label>
                <input type="text" name="patient_name" value="{{ old('patient_name', $report->patient_name) }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Phone <span class="text-red-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone', $report->phone) }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Patient ID</label>
                <input type="text" name="patient_id" value="{{ old('patient_id', $report->patient_id) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Age</label>
                <input type="text" name="age" value="{{ old('age', $report->age) }}" placeholder="e.g. 35 years"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Gender</label>
                <select name="gender" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="">-- Select --</option>
                    <option value="Male" {{ old('gender', $report->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $report->gender) == 'Female' ? 'selected' : '' }}>Female
                    </option>
                    <option value="Other" {{ old('gender', $report->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Referred By</label>
                <input type="text" name="referred_by" value="{{ old('referred_by', $report->referred_by) }}"
                    placeholder="Dr. Name / Self" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Report Date</label>
                <input type="date" name="report_date"
                    value="{{ old('report_date', $report->report_date?->format('Y-m-d')) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Report ID (ফাঁকা রাখলে auto-generate হবে)</label>
            <input type="text" name="report_id" value="{{ old('report_id', $report->report_id) }}"
                placeholder="RPT-XXXXXXXX" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                <option value="pending" {{ old('status', $report->status) == 'pending' ? 'selected' : '' }}>Pending
                </option>
                <option value="ready" {{ old('status', $report->status) == 'ready' ? 'selected' : '' }}>Ready</option>
            </select>
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">Option 1: Upload Existing PDF</h3>

        <div>
            <label class="block text-sm font-medium mb-1">Report File (PDF)</label>
            @if ($report->report_file)
                <p class="text-xs text-gray-500 mb-2"><a href="{{ asset('storage/' . $report->report_file) }}"
                        target="_blank" class="text-blue-600">Current PDF</a></p>
            @endif
            <input type="file" name="report_file" accept="application/pdf"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            <p class="text-xs text-gray-400 mt-1">যদি স্ক্যান করা আসল রিপোর্ট PDF থাকে, এখানে আপলোড করুন।</p>
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">Option 2: Enter Test Results (Auto-generates
            Letterhead PDF)</h3>

        <div class="space-y-3">
            <template x-for="(item, index) in items" :key="index">
                <div class="grid grid-cols-12 gap-2 items-center">
                    <input type="text" :name="'test_name[' + index + ']'" x-model="item.test_name"
                        placeholder="Test Name" class="col-span-4 border border-gray-200 rounded-md px-2 py-1.5 text-sm">
                    <input type="text" :name="'result_value[' + index + ']'" x-model="item.result_value"
                        placeholder="Result" class="col-span-2 border border-gray-200 rounded-md px-2 py-1.5 text-sm">
                    <input type="text" :name="'unit[' + index + ']'" x-model="item.unit" placeholder="Unit"
                        class="col-span-2 border border-gray-200 rounded-md px-2 py-1.5 text-sm">
                    <input type="text" :name="'normal_range[' + index + ']'" x-model="item.normal_range"
                        placeholder="Normal Range" class="col-span-3 border border-gray-200 rounded-md px-2 py-1.5 text-sm">
                    <label class="col-span-1 flex items-center gap-1 text-xs" :title="'Abnormal'">
                        <input type="checkbox" :name="'is_abnormal[' + index + ']'" value="1"
                            x-model="item.is_abnormal">
                        <button type="button" @click="removeItem(index)" class="text-red-500 ml-1">✕</button>
                    </label>
                </div>
            </template>

            <button type="button" @click="addItem()" class="text-sm text-brand hover:underline mt-2">+ Add Test
                Row</button>
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">Additional Info (ঐচ্ছিক, generated PDF-এ দেখাবে)
        </h3>

        <div>
            <label class="block text-sm font-medium mb-1">Comment / Remarks</label>
            <textarea name="comment" rows="3" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('comment', $report->comment) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Verified By</label>
            <input type="text" name="verified_by" value="{{ old('verified_by', $report->verified_by) }}"
                placeholder="Dr. Name, Consultant Pathologist"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <button type="submit" class="btn-primary">Save</button>
    </form>

    @php
        $initialItems = [];

        if ($report->exists && $report->items->count()) {
            foreach ($report->items as $existingItem) {
                $initialItems[] = [
                    'test_name' => $existingItem->test_name,
                    'result_value' => $existingItem->result_value,
                    'unit' => $existingItem->unit,
                    'normal_range' => $existingItem->normal_range,
                    'is_abnormal' => $existingItem->is_abnormal,
                ];
            }
        } else {
            $initialItems[] = [
                'test_name' => '',
                'result_value' => '',
                'unit' => '',
                'normal_range' => '',
                'is_abnormal' => false,
            ];
        }
    @endphp

    <script>
        function reportItemsForm() {
            return {
                items: @json($initialItems),
                addItem() {
                    this.items.push({
                        test_name: '',
                        result_value: '',
                        unit: '',
                        normal_range: '',
                        is_abnormal: false
                    });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
            };
        }
    </script>
@endsection
