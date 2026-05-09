@extends('layouts.app')
@section('title', 'Stock Management')
@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Stock Management</h2>
        <p class="text-sm text-gray-500">Outlet: {{ $outlet->name }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($products as $product)
            <x-card :padding="false">
                {{-- Product Header --}}
                <div class="bg-gray-800 text-white px-6 py-3 flex items-center gap-4">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 object-cover rounded-lg">
                    @endif
                    <div>
                        <p class="font-semibold">{{ $product->name }}</p>
                        <p class="text-gray-400 text-xs">{{ $product->category->name }}</p>
                    </div>
                </div>

                {{-- Variant Table --}}
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600">
                            <th class="px-6 py-2 text-left">Variant</th>
                            <th class="px-6 py-2 text-left">Current Stock</th>
                            <th class="px-6 py-2 text-left">Quantity</th>
                            <th class="px-6 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->variants as $variant)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="px-6 py-3 font-medium text-gray-700">
                                    Size {{ $variant->size }}
                                    <span class="text-gray-400 text-xs ml-1">
                                        Rp {{ number_format($variant->price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="font-bold text-gray-800">
                                        {{ $variant->stocks->first()->stock ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-6 py-3" colspan="2">
                                    <form action="{{ route('inventory.stocks.update') }}" method="POST"
                                        class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                        <input type="number" name="quantity" min="1" value="1"
                                            class="w-20 border border-gray-300 rounded-lg px-3 py-1 text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <x-button type="submit" name="type" value="in" variant="primary" size="sm">
                                            + Tambah
                                        </x-button>
                                       <x-button type="submit" name="type" value="out" variant="danger" size="sm">
                                            - Kurangi
                                        </x-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-card>
        @empty
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-400">
                No products found
            </div>
        @endforelse
    </div>

@endsection
