@extends('admin.layouts.app')

@section('title', 'New Sale')

@section('content')
    <div x-data="posForm()">
        <h2 class="text-lg font-semibold mb-5">New Medicine Sale</h2>

        <form action="{{ route('admin.medicine-sales.store') }}" method="POST"
            class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-3xl">
            @csrf

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">Customer Name</label>
                    <input type="text" name="customer_name" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Customer Phone</label>
                    <input type="text" name="customer_phone"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
            </div>

            <div class="space-y-3">
                <div class="grid grid-cols-12 gap-2 text-xs text-gray-500 font-medium px-1">
                    <span class="col-span-6">Medicine</span>
                    <span class="col-span-2">Qty</span>
                    <span class="col-span-2">Price</span>
                    <span class="col-span-2">Total</span>
                </div>

                <template x-for="(item, index) in items" :key="index">
                    <div class="grid grid-cols-12 gap-2 items-center">
                        <select :name="'medicine_id[' + index + ']'" x-model="item.medicineId" @change="updatePrice(index)"
                            required class="col-span-6 border border-gray-200 rounded-md px-2 py-1.5 text-sm">
                            <option value="">-- Select Medicine --</option>
                            @foreach ($medicines as $medicine)
                                <option value="{{ $medicine->id }}" data-price="{{ $medicine->price }}"
                                    data-stock="{{ $medicine->stock_quantity }}">
                                    {{ $medicine->name }} (Stock: {{ $medicine->stock_quantity }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" :name="'quantity[' + index + ']'" x-model.number="item.quantity"
                            @input="updatePrice(index)" min="1" value="1"
                            class="col-span-2 border border-gray-200 rounded-md px-2 py-1.5 text-sm">
                        <span class="col-span-2 text-sm text-gray-600" x-text="'Tk ' + item.unitPrice.toFixed(2)"></span>
                        <span class="col-span-1 text-sm font-medium"
                            x-text="'Tk ' + (item.unitPrice * item.quantity).toFixed(2)"></span>
                        <button type="button" @click="removeItem(index)" class="col-span-1 text-red-500 text-sm">✕</button>
                    </div>
                </template>

                <button type="button" @click="addItem()" class="text-sm text-brand hover:underline">+ Add Medicine</button>
            </div>

            <div class="grid grid-cols-2 gap-5 pt-4 border-t">
                <div>
                    <label class="block text-sm font-medium mb-1">Discount (Tk)</label>
                    <input type="number" step="0.01" name="discount" x-model.number="discount" min="0"
                        class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Subtotal: <span x-text="'Tk ' + subtotal().toFixed(2)"></span></p>
                    <p class="text-lg font-bold">Grand Total: <span x-text="'Tk ' + grandTotal().toFixed(2)"></span></p>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full">Complete Sale</button>
        </form>
    </div>

    <script>
        function posForm() {
            return {
                items: [{
                    medicineId: '',
                    quantity: 1,
                    unitPrice: 0
                }],
                discount: 0,

                addItem() {
                    this.items.push({
                        medicineId: '',
                        quantity: 1,
                        unitPrice: 0
                    });
                },
                removeItem(index) {
                    if (this.items.length > 1) this.items.splice(index, 1);
                },
                updatePrice(index) {
                    const select = document.querySelectorAll('select[name^="medicine_id"]')[index];
                    const selectedOption = select.options[select.selectedIndex];
                    this.items[index].unitPrice = parseFloat(selectedOption?.dataset.price || 0);
                },
                subtotal() {
                    return this.items.reduce((sum, item) => sum + (item.unitPrice * item.quantity), 0);
                },
                grandTotal() {
                    return Math.max(0, this.subtotal() - (this.discount || 0));
                },
            };
        }
    </script>
@endsection
