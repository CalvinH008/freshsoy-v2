<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(): View
    {
        $outlets = Outlet::all();
        $products = Product::with(['variants.stocks'])->get();
        return view('admin.stocks.index', compact('products', 'outlets'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'stocks' => ['required', 'array'],
            'stocks.*.*' => ['required', 'integer', 'min:0']
        ]);
        DB::transaction(function () use ($request) {
            foreach ($request->stocks as $variantId => $outletStocks) {
                foreach ($outletStocks as $outletId => $qty) {
                    $stockBefore = ProductStock::where('product_variant_id', $variantId)->where('outlet_id', $outletId)->first()?->stock ?? 0;
                    
                    ProductStock::updateOrCreate(
                        [
                            'product_variant_id' => $variantId,
                            'outlet_id' => $outletId
                        ],
                        [
                            'stock' => $qty
                        ]
                    );

                    StockMovement::create([
                        'product_variant_id' => $variantId,
                        'user_id' => Auth::id(),
                        'outlet_id' => $outletId,
                        'type' => 'adjustment',
                        'quantity' => $qty - $stockBefore,
                        'stock_before' => $stockBefore,
                        'stock_after' => $qty,
                        'note' => 'manual'
                    ]);
                }
            }
        });
        return redirect()->route('admin.products.index')->with('success', 'Stock Successfully');
    }
}
