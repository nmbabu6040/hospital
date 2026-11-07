@extends('admin.layouts.app')

@section('title', 'Custom Pages')

@section('content')
    <div class="flex justify-between items-center mb-5">
        <div>
            <h2 class="text-lg font-semibold">Custom Pages</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Privacy Policy, Terms, FAQ, Career ইত্যাদি নতুন পেজ এখান
                থেকে বানান।</p>
        </div>
        <a href="{{ route('admin.pages.create') }}" class="btn-primary">+ Add Page</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-3">Title</th>
                    <th class="p-3">Slug</th>
                    <th class="p-3">Menu</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr class="border-t">
                        <td class="p-3">{{ $page->title }}</td>
                        <td class="p-3 text-gray-400">/page/{{ $page->slug }}</td>
                        <td class="p-3">
                            @if ($page->show_in_menu)
                                <span
                                    class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">{{ ucfirst($page->menu_location) }}</span>
                            @else
                                <span class="text-gray-400 text-xs">Hidden</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs {{ $page->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $page->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('pages.show', $page) }}" target="_blank"
                                class="text-gray-500 hover:underline">View</a>
                            <a href="{{ route('admin.pages.edit', $page) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this page?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">কোনো কাস্টম পেজ নেই। "Add Page" দিয়ে
                            প্রথমটা বানান — যেমন Privacy Policy বা Terms & Conditions।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $pages->links() }}</div>
@endsection
