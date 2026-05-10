<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'outlet_id' => ['required', 'exists:outlets,id'],
            'amount_paid' => ['required', 'numeric'],
            'cart' => ['required', 'array'],
            'cart.*.variantId' => ['required', 'exists:product_variants,id'],
            'cart.*.price' => ['required', 'numeric'],
            'cart.*.quantity' => ['required', 'integer', 'min:1']
        ]);

        $outletId = auth()->user()->outlet_id;
        $total = collect($request->cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        try {
            DB::transaction(function () use ($request, $total, $outletId) {
                $order = Order::create([
                    'outlet_id' => $request->outlet_id,
                    'user_id' => auth()->id(),
                    'total_price' => $total,
                    'amount_paid' => $request->amount_paid,
                    'change' => $request->amount_paid - $total,
                    'status' => 'completed'
                ]);

                foreach ($request->cart as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_variant_id' => $item['variantId'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['price'] * $item['quantity']
                    ]);

                    $stockBefore = ProductStock::where('product_variant_id', $item['variantId'])
                        ->where('outlet_id', $outletId)
                        ->first()?->stock ?? 0;

                    ProductStock::where('product_variant_id', $item['variantId'])
                        ->where('outlet_id', $outletId)
                        ->decrement('stock', $item['quantity']);

                    $stockAfter = $stockBefore - $item['quantity'];

                    StockMovement::create([
                        'product_variant_id' => $item['variantId'],
                        'user_id' => auth()->id(),
                        'outlet_id' => $outletId,
                        'type' => 'out',
                        'quantity' => $item['quantity'],
                        'stock_before' => $stockBefore,
                        'stock_after' => $stockAfter,
                        'reference' => 'order-' . $order->id,
                        'note' => 'Tugas kasir'
                    ]);
                }
            });

            return response()->json([
                'message' => 'Order berhasil'
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'error' => $error->getMessage()
            ]);
        }
    }
}
