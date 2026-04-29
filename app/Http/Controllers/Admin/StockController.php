<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(): View
    {
        $stocks = Product::with(['variants.stocks'])->paginate(10);
        return view('admin.stocks.index', compact('stocks'));
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
                    ProductStock::updateOrCreate(
                        [
                            'product_variant_id' => $variantId,
                            'outlet_id' => $outletId
                        ],
                        [
                            'stock' => $qty
                        ]
                    );
                }
            }
        });
        return redirect()->route('admin.products.index')->with('success', 'Stock Successfully');
    }
}
