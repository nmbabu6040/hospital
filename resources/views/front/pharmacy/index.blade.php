@extends('layouts.app')

@section('title', 'Pharmacy')

@section('content')
    <section class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-6">Pharmacy</h1>

        <form method="GET" class="mb-8">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search medicine by name..."
                class="w-full md:w-96 border border-gray-200 rounded-md px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand">
        </form>

        <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="p-3">Medicine</th>
                        <th class="p-3">Category</th>
                        <th class="p-3">Manufacturer</th>
                        <th class="p-3">Price</th>
                        <th class="p-3">Availability</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medicines as $medicine)
                        <tr class="border-t">
                            <td class="p-3">
                                <p class="font-medium">{{ $medicine->name }}</p>
                                @if ($medicine->generic_name)
                                    <p class="text-xs text-gray-400">{{ $medicine->generic_name }}</p>
                                @endif
                                @if ($medicine->requires_prescription)
                                    <span class="text-xs bg-amber-50 text-amber-600 px-1.5 py-0.5 rounded">Prescription
                                        Required</span>
                                @endif
                            </td>
                            <td class="p-3 text-gray-500">{{ $medicine->category ?: '—' }}</td>
                            <td class="p-3 text-gray-500">{{ $medicine->manufacturer ?: '—' }}</td>
                            <td class="p-3 text-brand font-semibold">Tk {{ number_format($medicine->price, 2) }}</td>
                            <td class="p-3">
                                @if ($medicine->stock_quantity > 0)
                                    <span class="text-green-600 text-xs font-medium">● In Stock</span>
                                @else
                                    <span class="text-red-500 text-xs font-medium">● Out of Stock</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">কোনো ওষুধ পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">{{ $medicines->links() }}</div>

        <p class="text-xs text-gray-400 mt-6">* দাম ও স্টক পরিবর্তনশীল হতে পারে। সঠিক তথ্যের জন্য ফার্মেসিতে সরাসরি যোগাযোগ
            করুন।</p>
    </section>
@endsection
