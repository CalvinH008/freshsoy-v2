@extends('layouts.app')
@section('title', 'Cashier POS')
@section('content')

    <div x-data="posSystem()" x-init="outletId = {{ $outletId }}">
        <div class="flex gap-6 h-full">

            {{-- Kiri: Produk --}}
            <div class="flex-1">
                {{-- search input di sini --}}
                {{-- grid produk di sini --}}
            </div>

            {{-- Kanan: Cart --}}
            <div class="w-80 bg-white rounded-lg shadow p-4">
                {{-- list cart di sini --}}
                {{-- total di sini --}}
                {{-- tombol bayar di sini --}}
            </div>

        </div>
    </div>

@endsection
