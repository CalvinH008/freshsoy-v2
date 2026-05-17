<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function sales(Request $request): View
    {
        $date = $request->date ?? today();
        $orders = Order::query()
            ->where('outlet_id', Auth::user()->outlet_id)
            ->whereDate('created_at', $date)
            ->with(['items.variant.product', 'outlet', 'user', 'payment'])
            ->paginate(5);
        $total = Order::query()
            ->where('outlet_id', Auth::user()->outlet_id)
            ->whereDate('created_at', $date)
            ->sum('total_price');
        return view('manager.reports.sales', compact('date', 'orders', 'total'));
    }
}
