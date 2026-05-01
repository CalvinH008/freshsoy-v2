<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::withCount(['products'])
            ->when(request('search'), function ($q, $v) {
                $q->where(function ($query) use ($v) {
                    $query->where('name', 'LIKE', "%$v%")
                        ->orWhere('slug', 'LIKE', "%$v%");
                });
            })
            ->when(filled(request('is_active')), function ($q) {
                $q->where('is_active', request('is_active'));
            })
            ->paginate(5);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Category::create([
                    'name' => $request->validated('name'),
                    'slug' => Str::slug($request->validated('name')),
                    'description' => $request->validated('description'),
                    'is_active' => $request->validated('is_active') ?? true
                ]);
            });
            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
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
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $category) {
                $category->update([
                    'name' => $request->validated('name'),
                    'slug' => Str::slug($request->validated('name')),
                    'description' => $request->validated('description'),
                    'is_active' => $request->validated('is_active') ?? true
                ]);
            });
            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors(['error' => $error->getMessage()]);
        }
    }

    public function toggleStatus(Category $category): RedirectResponse{
        $category->update([
            'is_active' => !$category->is_active
        ]);
        return back();
    }
}
        