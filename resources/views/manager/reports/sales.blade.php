@extends('layouts.app')
@section('title', 'Sales')
@section('content')
    <form action=" {{ route('manager.reports.sales') }} " method="GET">
        <input type="date" name="date" value="{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}">
        <button type="submit">Filter</button>
    </form>

    <div class="mt-5">
        <x-card>
            <table class="w-full text-sm mt-6">
                <thead>
                    <tr>
                        <th class="text-left p-3 text-gray-500 font-medium">#</th>
                        <th class="text-left p-3 text-gray-500 font-medium">No Order</th>
                        <th class="text-left p-3 text-gray-500 font-medium">Cashier</th>
                        <th class="text-left p-3 text-gray-500 font-medium">Total Item</th>
                        <th class="text-left p-3 text-gray-500 font-medium">Total Price</th>
                        <th class="text-left p-3 text-gray-500 font-medium">Payment Method</th>
                        <th class="text-left p-3 text-gray-500 font-medium">Paid At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="p-3 border-t border-gray-100"> {{ $loop->iteration }} </td>
                            <td class="p-3 border-t border-gray-100"> {{ $order->id }} </td>
                            <td class="p-3 border-gray-100 border-t"> {{ $order->user->name }} </td>
                            <td class="p-3 border-t border-gray-100"> {{ $order->items->sum('quantity') }} </td>
                            <td class="p-3 border-t border-gray-100"> Rp.
                                {{ number_format($order->total_price, 0, ',', '.') }} </td>
                            <td class="p-3 border-t border-gray-100"> {{ $order->payment->payment_method ?? '-' }} </td>
                            <td class="p-3 border-t border-gray-100"> {{ $order->created_at->format('H:i') }} </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">
                                Tidak ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-card>
    </div>
@endsection
