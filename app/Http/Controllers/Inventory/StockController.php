<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $outlet = $user->outlet;

        $products = Product::with([
            'variants.stocks' => function ($q) use ($outlet) {
                $q->where('outlet_id', $outlet->id);
            }
        ])->get();

        return view('inventory.stocks.index', compact('products', 'outlet'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $outlet = $user->outlet;

        DB::transaction(function () use ($request, $outlet, $user) {
            $stock = ProductStock::where('product_variant_id', $request->variant_id)
                ->where('outlet_id', $outlet->id)
                ->first();

            $stockBefore = $stock?->stock ?? 0;

            if ($request->type === 'in') {
                $stockAfter = $stockBefore + $request->quantity;
            } else {
                $stockAfter = $stockBefore - $request->quantity;
            }

            // cegah stok minus
            if ($stockAfter < 0) {
                throw new \Exception('Stock tidak cukup');
            }

            ProductStock::updateOrCreate(
                [
                    'product_variant_id' => $request->variant_id,
                    'outlet_id' => $outlet->id
                ],
                [
                    'stock' => $stockAfter
                ]
            );

            StockMovement::create([
                'product_variant_id' => $request->variant_id,
                'user_id' => $user->id,
                'outlet_id' => $outlet->id,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'note' => 'inventory action'
            ]);
        });

        return back()->with('success', 'Stock berhasil diupdate');
    }
}
