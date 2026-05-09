@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Inventory Dashboard
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Monitor stock movement and inventory activity
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <x-card>
                <p class="text-sm text-gray-500">
                    Total Stock
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    {{ $totalStocks }}
                </h2>
            </x-card>

        </div>

        {{-- Table Section --}}
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Recent Stock Movements
                    </h2>

                    <p class="text-sm text-gray-500">
                        Latest inventory activity
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="px-4 py-3 text-left font-medium text-gray-600">#</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-600">Name</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-600">Size</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-600">Type</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-600">Stock Before</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-600">Stock After</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-600">Created At</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($movements as $movement)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-4 py-3">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $movement->variant?->product?->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $movement->variant?->size ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    <x-badge :variant="$movement->type === 'in' ? 'success' : 'danger'">
                                        {{ strtoupper($movement->type) }}
                                    </x-badge>
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $movement->stock_before }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $movement->stock_after }}
                                </td>

                                <td class="px-4 py-3 text-gray-500">
                                    {{ $movement->created_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                    No stock movement found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

    </div>
@endsection
