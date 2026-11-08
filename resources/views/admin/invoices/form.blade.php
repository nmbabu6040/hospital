@extends('admin.layouts.app')

@section('title', $invoice->exists ? 'Edit Invoice' : 'Create Invoice')

@section('content')
    <form action="{{ $invoice->exists ? route('admin.invoices.update', $invoice) : route('admin.invoices.store') }}"
        method="POST" class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-3xl" x-data="invoiceItemsForm()">
        @csrf
        @if ($invoice->exists)
            @method('PUT')
        @endif

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4">Patient Information</h3>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Patient Name <span class="text-red-500">*</span></label>
                <input type="text" name="patient_name" value="{{ old('patient_name', $invoice->patient_name) }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Phone <span class="text-red-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone', $invoice->phone) }}" required
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $invoice->email) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Invoice Date <span class="text-red-500">*</span></label>
                <input type="date" name="invoice_date"
                    value="{{ old('invoice_date', $invoice->invoice_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                    required class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Related Appointment (ঐচ্ছিক)</label>
                <select name="appointment_id" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="">-- None --</option>
                    @foreach ($appointments as $appointment)
                        <option value="{{ $appointment->id }}"
                            {{ old('appointment_id', $invoice->appointment_id) == $appointment->id ? 'selected' : '' }}>
                            {{ $appointment->name }} - {{ $appointment->doctor?->name ?? 'N/A' }}
                            ({{ \Illuminate\Support\Carbon::parse($appointment->date)->format('d M') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Related Package (ঐচ্ছিক)</label>
                <select name="package_id" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="">-- None --</option>
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}"
                            {{ old('package_id', $invoice->package_id) == $package->id ? 'selected' : '' }}>
                            {{ $package->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Hospital Branch (ঐচ্ছিক)</label>
            <select name="hospital_id" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                <option value="">-- None --</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}"
                        {{ old('hospital_id', $invoice->hospital_id) == $hospital->id ? 'selected' : '' }}>
                        {{ $hospital->name }}</option>
                @endforeach
            </select>
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">Invoice Items</h3>

        <div class="space-y-3">
            <div class="grid grid-cols-12 gap-2 text-xs text-gray-500 font-medium px-1">
                <span class="col-span-6">Item Name</span>
                <span class="col-span-2">Qty</span>
                <span class="col-span-3">Unit Price</span>
                <span class="col-span-1"></span>
            </div>

            <template x-for="(item, index) in items" :key="index">
                <div class="grid grid-cols-12 gap-2 items-center">
                    <input type="text" :name="'item_name[' + index + ']'" x-model="item.item_name"
                        placeholder="e.g. Consultation Fee, Blood Test"
                        class="col-span-6 border border-gray-200 rounded-md px-2 py-1.5 text-sm">
                    <input type="number" :name="'quantity[' + index + ']'" x-model="item.quantity" min="1"
                        placeholder="1" class="col-span-2 border border-gray-200 rounded-md px-2 py-1.5 text-sm">
                    <input type="number" step="0.01" :name="'unit_price[' + index + ']'" x-model="item.unit_price"
                        placeholder="0.00" class="col-span-3 border border-gray-200 rounded-md px-2 py-1.5 text-sm">
                    <button type="button" @click="removeItem(index)" class="col-span-1 text-red-500 text-sm">✕</button>
                </div>
            </template>

            <button type="button" @click="addItem()" class="text-sm text-brand hover:underline mt-2">+ Add Item</button>
        </div>

        <div class="grid grid-cols-2 gap-5 pt-4 border-t">
            <div>
                <label class="block text-sm font-medium mb-1">Discount (৳)</label>
                <input type="number" step="0.01" name="discount" value="{{ old('discount', $invoice->discount ?? 0) }}"
                    min="0" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Payment Status</label>
                <select name="payment_status" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                    <option value="unpaid"
                        {{ old('payment_status', $invoice->payment_status ?? 'unpaid') == 'unpaid' ? 'selected' : '' }}>
                        Unpaid</option>
                    <option value="paid"
                        {{ old('payment_status', $invoice->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="partial"
                        {{ old('payment_status', $invoice->payment_status) == 'partial' ? 'selected' : '' }}>Partial
                    </option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Payment Method</label>
            <input type="text" name="payment_method" value="{{ old('payment_method', $invoice->payment_method) }}"
                placeholder="Cash, bKash, Card etc." class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Notes</label>
            <textarea name="notes" rows="2" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('notes', $invoice->notes) }}</textarea>
        </div>

        <button type="submit" class="btn-primary">Save Invoice</button>
    </form>

    @php
        $initialInvoiceItems = [];
        if ($invoice->exists && $invoice->items->count()) {
            foreach ($invoice->items as $existingItem) {
                $initialInvoiceItems[] = [
                    'item_name' => $existingItem->item_name,
                    'quantity' => $existingItem->quantity,
                    'unit_price' => $existingItem->unit_price,
                ];
            }
        } else {
            $initialInvoiceItems[] = ['item_name' => '', 'quantity' => 1, 'unit_price' => ''];
        }
    @endphp

    <script>
        function invoiceItemsForm() {
            return {
                items: @json($initialInvoiceItems),
                addItem() {
                    this.items.push({
                        item_name: '',
                        quantity: 1,
                        unit_price: ''
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
