@extends('admin.layouts.app')

@section('title', 'Packages')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold">All Packages</h2>
        <a href="{{ route('admin.packages.create') }}" class="btn-primary">+ Add Package</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $package)
                    <tr class="border-t">
                        <td class="p-3">{{ $package->name }}</td>
                        <td class="p-3">৳{{ number_format($package->price) }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.packages.edit', $package) }}"
                                class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this package?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-5 text-center text-gray-500">No packages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $packages->links() }}</div>
@endsection
