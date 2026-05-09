<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalStocks = ProductStock::where('outlet_id', auth()->user()->outlet_id)->sum('stock');
        $movements = StockMovement::where('outlet_id', auth()->user()->outlet_id)
            ->with(['variant.product'])
            ->latest()
            ->take(5)
            ->get();
        return view('inventory.dashboard', compact('totalStocks', 'movements'));
    }
}
