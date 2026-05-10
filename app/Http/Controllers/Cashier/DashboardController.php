<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $outletId = auth()->user()->outlet_id;
        return view('cashier.pos', compact('outletId'));
    }
}
