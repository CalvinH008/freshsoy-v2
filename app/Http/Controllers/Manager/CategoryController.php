<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
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
        return view('manager.categories.index', compact('categories'));
    }

}
