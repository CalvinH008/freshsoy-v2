<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with(['category', 'variants.stocks'])
            ->when(request('search'), function ($q, $v) {
                $q->where(function ($query) use ($v) {
                    $query->where('name', 'LIKE', "%$v%")
                        ->orWhereHas('category', function ($r) use ($v) {
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
    public function create(): View
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $data = $request->validated();
                if ($request->hasFile('image')) {
                    $data['image'] = $request->file('image')->store('products', 'public');
                }
                $product = Product::create($data);

                $variants = $request->input('variants', []);

                $variantsData = array_map(function ($variant) {
                    return [
                        'size' => $variant['size'],
                        'price' => $variant['price']
                    ];
                }, $variants);

                if (!empty($variantsData)) {
                    $product->variants()->createMany($variantsData);
                }
            });
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
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
    public function edit(Product $product): View
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $product) {
                $data = $request->validated();
                if ($request->hasFile('image')) {
                    if ($product->image) {
                        Storage::disk('public')->delete($product->image);
                    }
                    $data['image'] = $request->file('image')->store('products', 'public');
                }
                $product->update($data);

                $product->variants()->delete();

                $variants = $request->input('variants', []);

                $variantsData = array_map(function ($variant) {
                    return [
                        'size' => $variant['size'],
                        'price' => $variant['price']
                    ];
                }, $variants);

                if (!empty($variantsData)) {
                    $product->variants()->createMany($variantsData);
                }
            });
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }
}
