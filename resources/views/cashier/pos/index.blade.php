@extends('layouts.app')
@section('title', 'Cashier POS')
@section('content')

    <div x-data="posSystem({{ $outletId }})" class="flex gap-4" style="height: calc(100vh - 80px)">

        {{-- KIRI: PRODUK --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- SEARCH --}}
            <div class="mb-4">
                <input type="search" x-model="search" placeholder="🔍 Cari produk..."
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white shadow-sm">
            </div>

            {{-- GRID PRODUK --}}
            <div class="overflow-y-auto flex-1">
                <div class="grid grid-cols-2 xl:grid-cols-3 gap-3">
                    <template x-for="product in products" :key="product.id">
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">

                            {{-- IMAGE --}}
                            <div class="relative h-28 bg-gray-100">
                                <img :src="product.image" class="w-full h-full object-cover">
                                <span
                                    class="absolute top-2 left-2 bg-white text-xs text-gray-500 px-2 py-0.5 rounded-full shadow-sm"
                                    x-text="product.category"></span>
                            </div>

                            {{-- INFO --}}
                            <div class="p-3">
                                <p class="font-semibold text-gray-800 text-sm truncate mb-2" x-text="product.name"></p>

                                {{-- VARIANTS --}}
                                <div class="space-y-1">
                                    <template x-for="variant in product.variants" :key="variant.id">
                                        <button type="button"
                                            class="w-full flex justify-between items-center px-3 py-2 rounded-lg text-xs transition border"
                                            :class="variant.stock <= 0 ?
                                                'border-gray-200 text-gray-300 cursor-not-allowed bg-gray-50' :
                                                'border-blue-100 text-gray-700 hover:bg-blue-50 hover:border-blue-400 bg-white'"
                                            :disabled="variant.stock <= 0" @click="addToCart(variant, product.name)">
                                            <span class="font-medium" x-text="'Size ' + variant.size"></span>
                                            <div class="text-right">
                                                <div class="font-bold text-blue-600"
                                                    x-text="'Rp ' + variant.price.toLocaleString('id-ID')"></div>
                                                <div class="text-gray-400" x-text="'Stok: ' + variant.stock"></div>
                                            </div>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- KANAN: CART --}}
        <div class="w-96 bg-white rounded-xl shadow border border-gray-100 flex flex-col overflow-hidden">

            {{-- HEADER --}}
            <div class="px-5 py-4 border-b bg-gray-50">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-gray-800">Cart</h2>
                    <span class="bg-blue-100 text-blue-600 text-xs font-medium px-2 py-0.5 rounded-full"
                        x-text="cart.length + ' item'"></span>
                </div>
            </div>

            {{-- LIST ITEM --}}
            <div class="flex-1 overflow-y-auto px-4 py-3 space-y-2">
                <template x-for="item in cart" :key="item.variantId">
                    <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-800 truncate" x-text="item.name"></p>
                            <p class="text-xs text-gray-400" x-text="'Size ' + item.size"></p>
                            <p class="text-xs font-bold text-blue-600 mt-0.5"
                                x-text="'Rp ' + (item.price * item.quantity).toLocaleString('id-ID')"></p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button @click="item.quantity > 1 ? item.quantity-- : removeFromCart(item.variantId)"
                                class="w-7 h-7 rounded-full bg-white border border-gray-200 hover:bg-red-50 hover:border-red-300 text-gray-600 text-sm font-bold flex items-center justify-center transition">
                                −
                            </button>
                            <span class="w-5 text-center text-sm font-semibold" x-text="item.quantity"></span>
                            <button @click="item.quantity < item.stock ? item.quantity++ : null"
                                class="w-7 h-7 rounded-full bg-white border border-gray-200 hover:bg-green-50 hover:border-green-300 text-gray-600 text-sm font-bold flex items-center justify-center transition">
                                +
                            </button>
                        </div>
                    </div>
                </template>

                <div x-show="cart.length === 0" class="flex flex-col items-center justify-center py-12 text-gray-400">
                    <p class="text-sm">Cart masih kosong</p>
                    <p class="text-xs mt-1">Pilih produk di sebelah kiri</p>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="px-5 py-4 border-t bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500 text-sm">Total Pembayaran</span>
                    <span class="font-bold text-xl text-gray-800" x-text="'Rp ' + total.toLocaleString('id-ID')"></span>
                </div>
                <button class="w-full py-3 rounded-xl font-semibold text-sm transition"
                    :class="cart.length === 0 ?
                        'bg-gray-200 text-gray-400 cursor-not-allowed' :
                        'bg-blue-600 text-white hover:bg-blue-700'"
                    :disabled="cart.length === 0" x-on:click="showModal = true">
                    Proses Pembayaran
                </button>
            </div>
        </div>

        <div x-show="showModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-transition>
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4">
                {{-- header --}}
                <div class="px-6 py-4 border-b">
                    <h3 class="font-bold text-lg text-gray-800">Konfirmasi Pembayaran</h3>
                </div>
                <div class="px-6 py-5 space-y-4">

                    {{-- Total --}}
                    <div class="flex justify-between items-center bg-blue-50 rounded-xl px-4 py-3">
                        <span class="text-sm text-gray-600">Total Belanja</span>
                        <span class="font-bold text-xl text-blue-600" x-text="'Rp ' + total.toLocaleString('id-ID')"></span>
                    </div>

                    {{-- Input nominal --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Bayar</label>
                        <input type="number" x-model="amountPaid"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="0">
                    </div>

                    {{-- Kembalian --}}
                    <div class="flex justify-between items-center bg-green-50 rounded-xl px-4 py-3">
                        <span class="text-sm text-gray-600">Kembalian</span>
                        <span class="font-bold text-xl text-green-600"
                            x-text="'Rp ' + change.toLocaleString('id-ID')"></span>
                    </div>

                    {{-- Error message --}}
                    <div x-show="errorMessage" class="bg-red-50 text-red-500 text-sm rounded-xl px-4 py-3">
                        <span x-text="errorMessage"></span>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="px-6 py-4 border-t flex gap-3">
                    <button @click="showModal = false; errorMessage=''"
                        class="flex-1 py-3 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-50 transition font-medium text-sm">
                        Batal
                    </button>
                    <button @click="bayar()" :disabled="amountPaid < total"
                        :class="amountPaid < total ?
                            'bg-gray-200 text-gray-400 cursor-not-allowed' :
                            'bg-blue-600 text-white hover:bg-blue-700'"
                        class="flex-1 py-3 rounded-xl font-semibold text-sm transition">
                        Konfirmasi Bayar
                    </button>
                </div>
            </div>
        </div>

        {{-- MODAL STRUK --}}
        <div x-show="showReceipt"
            class="fixed inset-0 bg-black/50 flex justify-center items-start pt-10 z-50 overflow-y-auto">

            <div id="receipt" class="bg-white w-[340px] rounded-md shadow-2xl border border-gray-200 text-sm font-mono">

                {{-- HEADER --}}
                <div class="text-center px-4 pt-5">
                    <h2 class="font-bold text-base uppercase tracking-wide" x-text="receipt?.outlet?.name">
                    </h2>

                    <p class="text-xs mt-1 text-gray-600">
                        POS Receipt
                    </p>

                    <p class="text-[11px] text-gray-500 mt-1"
                        x-text="new Date(receipt?.order?.created_at).toLocaleString('id-ID')">
                    </p>
                </div>

                {{-- GARIS --}}
                <div class="border-t border-dashed border-gray-400 my-4"></div>

                {{-- ITEMS --}}
                <div class="px-4 space-y-3">

                    <template x-for="item in receipt?.order?.items" :key="item.id">

                        <div>

                            {{-- NAMA --}}
                            <div class="flex justify-between gap-3">

                                <p class="break-words" x-text="item.variant?.product?.name">
                                </p>

                                <p class="shrink-0" x-text="'Rp ' + item.subtotal.toLocaleString('id-ID')">
                                </p>

                            </div>

                            {{-- DETAIL --}}
                            <div class="flex justify-between text-xs text-gray-500 mt-1">

                                <p x-text="'Size ' + item.variant?.size"></p>

                                <p x-text="item.quantity + ' x Rp ' + item.price.toLocaleString('id-ID')"></p>

                            </div>

                        </div>

                    </template>

                </div>

                {{-- GARIS --}}
                <div class="border-t border-dashed border-gray-400 my-4"></div>

                {{-- TOTAL --}}
                <div class="px-4 space-y-2">

                    <div class="flex justify-between">
                        <span>Total</span>

                        <span class="font-bold" x-text="'Rp ' + receipt?.order?.total_price?.toLocaleString('id-ID')">
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Bayar</span>

                        <span x-text="'Rp ' + receipt?.order?.amount_paid?.toLocaleString('id-ID')">
                        </span>
                    </div>

                    <div class="flex justify-between font-bold text-base">
                        <span>Kembali</span>

                        <span x-text="'Rp ' + receipt?.order?.change?.toLocaleString('id-ID')">
                        </span>
                    </div>

                </div>

                {{-- GARIS --}}
                <div class="border-t border-dashed border-gray-400 my-4"></div>

                {{-- FOOTER --}}
                <div class="px-4 pb-5 text-center">

                    <p class="text-xs text-gray-600" x-text="'Kasir: ' + receipt?.cashier">
                    </p>

                    <p class="text-xs text-gray-500 mt-2">
                        Terima kasih sudah berbelanja
                    </p>

                    {{-- BUTTON --}}
                    <div class="flex gap-2 mt-5 no-print">

                        <button @click="window.open(`/cashier/orders/${receipt.order.id}/receipt`)"
                            class="flex-1 py-2 bg-black text-white rounded text-sm hover:bg-gray-800 transition">
                            Cetak
                        </button>

                        <button @click="showReceipt = false"
                            class="flex-1 py-2 border border-gray-300 rounded text-sm hover:bg-gray-50 transition">
                            Tutup
                        </button>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
