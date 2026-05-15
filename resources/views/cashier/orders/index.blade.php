@extends('layouts.app')

@section('title', 'Orders History')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Orders History
        </h2>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="px-4 py-3 text-left">No Order</th>
                    <th class="px-4 py-3 text-left">Created At</th>
                    <th class="px-4 py-3 text-left">Total Item</th>
                    <th class="px-4 py-3 text-left">Total Price</th>
                    <th class="px-4 py-3 text-left">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-4 py-3 text-gray-600">
                            #{{ $order->id }}
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ $order->items->sum('quantity') }}
                        </td>

                        <td class="px-4 py-3 font-medium text-gray-800">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3">
                            <x-badge :variant="match ($order->status) {
                                'completed' => 'success',
                                'pending' => 'warning',
                                'processing' => 'info',
                                'canceled' => 'danger',
                                default => '',
                            }">
                                {{ $order->status }}
                            </x-badge>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            No Order History Found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

@endsection
