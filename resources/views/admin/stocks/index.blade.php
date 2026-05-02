@extends('layouts.app')
@section('title', 'Stock Management')
@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Stock Management</h2>
        <a href="{{ route('admin.products.index') }}"
            class="border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
            Back
        </a>
    </div>

    <form action="{{ route('admin.stocks.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow overflow-hidden">
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
                                @foreach ($outlets as $outlet)
                                    <th class="px-6 py-2 text-left">{{ $outlet->name }}</th>
                                @endforeach
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
                                    @foreach ($outlets as $outlet)
                                        <td class="px-6 py-3">
                                            <input type="number" name="stocks[{{ $variant->id }}][{{ $outlet->id }}]"
                                                value="{{ $variant->stocks->where('outlet_id', $outlet->id)->first()->stock ?? 0 }}"
                                                min="0"
                                                class="w-24 border border-gray-300 rounded-lg px-3 py-1 text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                Save 
            </button>
        </div>
    </form>

@endsection
