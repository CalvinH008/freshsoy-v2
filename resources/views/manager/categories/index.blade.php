@extends('layouts.app')
@section('title', 'Category View')
@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Category</h2>
    </div>

    {{-- Search & Filter --}}
    <form action="{{ route('manager.categories.index') }}" method="GET"
        class="flex gap-3 mb-6 bg-white p-4 rounded-lg shadow">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Find Category..."
            class="border border-gray-300 rounded-lg px-3 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <select name="is_active" class="border border-gray-300 rounded-lg px-3 py-2">
            <option value="" disabled selected>Status</option>
            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            Filter
        </button>
        <a href="{{ route('manager.categories.index') }}"
            class="border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
            Reset
        </a>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="px-4 py-3 text-left w-10">#</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Slug</th>
                    <th class="px-4 py-3 text-left">Description</th>
                    <th class="px-4 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $category->slug }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $category->description ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            No categories found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $categories->links() }}
    </div>

@endsection
