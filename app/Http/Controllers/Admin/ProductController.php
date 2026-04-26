<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with(['category', 'variants'])
            ->when(request('search'), function ($q, $v) {
                $q->where(function ($query) use($v) {
                    $query->where('name', 'LIKE', "%$v%")
                        ->orWhereHas('category', function ($r) use($v) {
                            $r->where('name', 'LIKE', "%$v%");
                        });
                }); 
            })
            ->when(filled(request('is_active')), function ($q) {
                $q->where('is_active', request('is_active'));
            })
            ->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
