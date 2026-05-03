<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $outletId = auth()->user()->outlet_id;
        $outlet = Outlet::findOrFail($outletId);
        $totalProducts = $outlet->productStocks()->where('stock', '>', 0)
            ->whereHas('variant.product', function ($q) {
                $q->where('is_active', true);
            })
            ->join('product_variants', 'product_stocks.product_variant_id', '=', 'product_variants.id')
            ->distinct()
            ->count('product_id');
        $totalStock = $outlet->productStocks()->sum('stock');
        $totalCashiers = User::where('outlet_id', $outlet->id)
            ->role('cashier')
            ->count();
        $lowStocks = $outlet->productStocks()->where('stock', '<', 10)->with(['variant.product'])->orderBy('stock', 'asc')->get();
        return view('manager.dashboard', compact('outlet', 'totalProducts', 'totalStock', 'totalCashiers', 'lowStocks'));
    }
}
