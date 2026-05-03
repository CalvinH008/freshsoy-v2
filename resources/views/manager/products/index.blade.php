@extends('layouts.app')
@section('title', 'Products')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Product Overview</h2>
    </div>

    <form action=" {{ route('manager.products.index') }} " method="GET"
        class="flex gap-3 mb-6 bg-white p-4 rounded-lg shadow">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Find Product..."
            class="border border-gray-300 rounded-lg px-3 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <select name="is_active" class="border border-gray-300 rounded-lg px-3 py-2">
            <option value="" disabled selected>Status</option>
            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit"
            class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">Filter</button>
        <a href=" {{ route('manager.products.index') }} "
            class="border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-100 transition">Reset</a>
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="px-4 py-3 text-left w-10">#</th>
                    <th class="px-4 py-3 text-left">Image</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Category</th>
                    <th class="px-4 py-3 text-left">Variants</th>
                    <th class="px-4 py-3 text-left">Stock</th>
                    <th class="px-4 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    class="w-12 h-12 object-cover rounded-lg">
                            @else
                                <div
                                    class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-xs">
                                    No img
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $product->category->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $product->variants->count() }} variant</td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $product->variants->sum(fn($v) => $v->stocks->sum('stock')) }}
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                            No products found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
