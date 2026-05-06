<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function index(): View
    {
        $outlets = Outlet::all();
        $movements = StockMovement::query()
            ->with(['variant.product', 'outlet', 'user'])
            ->when(filled(request('outlet_id')), fn($q) => $q->where('outlet_id', request('outlet_id')))
            ->when(request('search'), function ($q, $v) {
                $q->whereHas('variant.product', fn($r) => $r->where('name', "LIKE", "%$v%"));
            })
            ->paginate(12);

        return view('admin.stock_movements.index', compact('movements', 'outlets'));
    }
}
