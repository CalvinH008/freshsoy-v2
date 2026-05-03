@extends('layouts.app')
@section('title', 'Manager Dashboard')
@section('content')
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">{{ $outlet->name }}</h1>
        <p class="text-sm text-gray-500">Manager Dashboard</p>
    </div>

    {{-- report card --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <x-card>
            <p class="text-sm text-gray-500">Total Products</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalProducts }}</h2>
        </x-card>
        <x-card>
            <p class="text-sm text-gray-500">Total Stock</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalStock }}</h2>
        </x-card>
        <x-card>
            <p class="text-sm text-gray-500">Total Cashier</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalCashiers }}</h2>
        </x-card>
    </div>

    {{-- low stock alert --}}
    <div class="mt-5">
        <x-card>
            <table class="w-full text-sm mt-6">
                <thead>
                    <tr>
                        <th class="text-left p-3 text-gray-500 font-medium">Product</th>
                        <th class="text-left p-3 text-gray-500 font-medium">Variant</th>
                        <th class="text-left p-3 text-gray-500 font-medium">Stock</th>
                        <th class="text-left p-3 text-gray-500 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowStocks as $stock)
                        <tr>
                            <td class="p-3 border-t border-gray-100"> {{ $stock->variant->product->name }} </td>
                            <td class="p-3 border-t border-gray-100"> {{ $stock->variant->size }} </td>
                            <td class="p-3 border-t border-gray-100"> {{ $stock->stock }} </td>
                            <td class="p-3 border-t border-gray-100">
                                @if ($stock->stock <= 4)
                                    <x-badge variant="danger">Very Low</x-badge>
                                @elseif ($stock->stock <= 9)
                                    <x-badge variant="warning">Low</x-badge>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                Semua stok aman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-card>
    </div>
@endsection
