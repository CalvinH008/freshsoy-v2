<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductStock;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount_paid' => ['required', 'numeric'],
            'cart' => ['required', 'array'],
            'cart.*.variantId' => ['required', 'exists:product_variants,id'],
            'cart.*.quantity' => ['required', 'integer', 'min:1']
        ]);

        $outletId = auth()->user()->outlet_id;

        $variantIds = collect($request->cart)->pluck('variantId');
        $variants = ProductVariant::whereIn('id', $variantIds)->get()->keyBy('id');
        $stocks = ProductStock::whereIn('product_variant_id', $variantIds)
            ->where('outlet_id', $outletId)
            ->get()
            ->keyBy('product_variant_id');

        $total = collect($request->cart)->sum(
            fn($item) =>
            $variants[$item['variantId']]->price * $item['quantity']
        );

        foreach ($request->cart as $item) {
            $stock = $stocks[$item['variantId']]?->stock ?? 0;
            if ($stock < $item['quantity']) {
                return response()->json([
                    'error' => 'Stok tidak cukup untuk variant ' . $item['variantId']
                ], 422);
            }
        }

        $order = null;

        if ($request->amount_paid < $total) {
            return response()->json(['error' => 'Nominal bayar kurang'], 422);
        }

        try {
            DB::transaction(function () use ($request, $total, $outletId, &$order, $variants, $stocks) {
                $order = Order::create([
                    'outlet_id' => $outletId,
                    'user_id' => auth()->id(),
                    'total_price' => $total,
                    'amount_paid' => $request->amount_paid,
                    'change' => $request->amount_paid - $total,
                    'status' => 'completed'
                ]);

                foreach ($request->cart as $item) {
                    $variant = $variants[$item['variantId']];
                    $price = $variant->price;
                    $subtotal = $price * $item['quantity'];
                    $stockBefore = $stocks[$item['variantId']]?-> stock ?? 0;
                    $stockAfter = $stockBefore - $item['quantity'];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_variant_id' => $item['variantId'],
                        'quantity' => $item['quantity'],
                        'price' => $price,
                        'subtotal' => $subtotal
                    ]);

                    ProductStock::where('product_variant_id', $item['variantId'])
                        ->where('outlet_id', $outletId)
                        ->decrement('stock', $item['quantity']);

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
                'message' => 'Order berhasil',
                'order' => $order->load('items.variant.product'),
                'outlet' => $order->outlet,
                'cashier' => auth()->user()->name
            ], 201);
        } catch (\Exception $error) {
            return response()->json([
                'error' => $error->getMessage()
            ], 500);
        }
    }

    public function receipt(Order $order){
        $order->load(['items.variant.product', 'outlet', 'user']);
        $pdf = Pdf::loadView('cashier.pos.receipt', compact('order'));
        return $pdf->download("receipt-{$order->id}.pdf");
    }

    public function history(): View{
        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->whereDate('created_at', today())
            ->with(['items.variant.product', 'outlet', 'user'])
            ->latest()
            ->paginate(10);

        return view('cashier.orders.index', compact('orders'));
    }
}
