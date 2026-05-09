<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function index(): View
    {
        $movements = StockMovement::query()
            ->with(['variant.product', 'outlet', 'user'])
            ->where('outlet_id', auth()->user()->outlet_id)
            ->when(request('search'), function ($q, $v) {
                $q->whereHas('variant.product', fn($r) => $r->where('name', "LIKE", "%$v%"));
            })
            ->paginate(12);
        return view('inventory.stock_movements.index', compact('movements'));
    }
}
