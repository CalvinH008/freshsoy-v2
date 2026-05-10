@extends('layouts.app')
@section('title', 'Cashier POS')

@section('content')

    <div x-data="posSystem({{ $outletId }})">

        <div class="flex gap-6 h-full">

            {{-- KIRI: PRODUCT --}}
            <div class="flex-1">

                {{-- FILTER --}}
                <div class="mb-4 flex gap-2">
                    <input type="search" x-model="search" placeholder="Find Product..." class="border p-2 rounded w-full">

                    <select class="border p-2 rounded">
                        <option value="">Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                {{-- GRID --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <template x-for="product in products" :key="product.id">

                        <div class="bg-white rounded-lg shadow p-4">

                            {{-- PRODUCT NAME --}}
                            <h2 class="font-bold text-lg" x-text="product.name"></h2>

                            {{-- VARIANTS --}}
                            <div class="mt-3 space-y-2">

                                <template x-for="variant in product.variants" :key="variant.id">

                                    <button type="button" class="w-full border p-2 rounded hover:bg-gray-100"
                                        @click="addToCart(variant, product.name)">
                                        <span x-text="variant.size"></span>
                                        -
                                        <span x-text="variant.price"></span>
                                    </button>

                                </template>

                            </div>

                        </div>

                    </template>

                </div>

            </div>

            {{-- KANAN: CART --}}
            <div class="w-80 bg-white rounded-lg shadow p-4">

                <h2 class="font-bold text-lg mb-3">Cart</h2>

                <template x-for="item in cart" :key="item.variantId">

                    <div class="border-b py-2">

                        <div class="flex justify-between">
                            <div>
                                <div x-text="item.name"></div>
                                <small x-text="item.size"></small>
                            </div>

                            <div>
                                x <span x-text="item.quantity"></span>
                            </div>
                        </div>

                    </div>

                </template>

                <div class="mt-4 font-bold">
                    Total: <span x-text="total"></span>
                </div>

                <button class="w-full mt-4 bg-blue-500 text-white p-2 rounded">
                    Bayar
                </button>

            </div>

        </div>

    </div>

@endsection
