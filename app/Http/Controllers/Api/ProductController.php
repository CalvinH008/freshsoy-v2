<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $outletId = $request->outlet_id;
        $products = Product::with(['category', 'variants.stocks' => fn($q) => $q->where('outlet_id', $outletId)])
            ->when($request->search, function ($q, $search) {
                $q->where('name', "LIKE", "%{$search}%");
            })
            ->where('is_active', true)
            ->get();
        return ProductResource::collection($products);
    }
}
