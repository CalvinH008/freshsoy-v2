<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with(['category', 'variants.stocks'])
            ->when($request->search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->whereHas('variants.stocks', function ($q) {
                $q->where('outlet_id', auth()->user()->outlet_id);
            })
            ->when(filled(request('is_active')) , function ($q) {
                $q->where('is_active', request('is_active'));
            })
            ->paginate(12);

        return view('manager.products.index', compact('products'));
    }
}
