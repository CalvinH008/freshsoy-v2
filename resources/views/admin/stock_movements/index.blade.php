@extends('layouts.app')
@section('title', 'Stock Movement')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Stock Movements</h2>
    </div>
    <form action=" {{ route('admin.stock-movements.index') }} " method="GET"
        class="flex gap-3 mb-6 bg-white p-4 rounded-lg shadow">
        <input type="search" value="{{ request('search') }}" name="search"
            class="border border-gray-300 rounded-lg px-3 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Search product by name...">
        <select name="outlet_id" class="border border-gray-300 rounded-lg px-3 py-2">
            <option value="">Semua Outlet</option>
            @foreach ($outlets as $outlet)
                <option value="{{ $outlet->id }}" {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>
                    {{ $outlet->name }}
                </option>
            @endforeach
        </select>
        <button type="submit"
            class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">Search</button>
        <a href=" {{ route('admin.stock-movements.index') }} "
            class="border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-100 transition">Reset</a>
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden mt-5">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="px-4 py-3 text-left">Product Name</th>
                    <th class="px-4 py-3 text-left">Product Size</th>
                    <th class="px-4 py-3 text-left">Outlet</th>
                    <th class="px-4 py-3 text-left">Updated By</th>
                    <th class="px-4 py-3 text-left">Type</th>
                    <th class="px-4 py-3 text-left">Stock Before</th>
                    <th class="px-4 py-3 text-left">Quantity</th>
                    <th class="px-4 py-3 text-left">Stock After</th>
                    <th class="px-4 py-3 text-left">Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movements as $movement)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-500"> {{ $movement->variant->product->name }} </td>
                        <td class="px-4 py-3 text-gray-500"> {{ $movement->variant->size }} </td>
                        <td class="px-4 py-3 text-gray-500"> {{ $movement->outlet->name }} </td>
                        <td class="px-4 py-3 text-gray-500"> {{ $movement->user->name }} </td>
                        <td class="px-4 py-3 text-gray-500"> {{ $movement->type }} </td>
                        <td class="px-4 py-3 text-gray-500"> {{ $movement->stock_before }} </td>
                        <td class="px-4 py-3 text-gray-500"> {{ $movement->quantity }} </td>
                        <td class="px-4 py-3 text-gray-500"> {{ $movement->stock_after }} </td>
                        <td> {{ $movement->created_at->format('d M Y H:i') }} </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-400">No Stock Movement Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
