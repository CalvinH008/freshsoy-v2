<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::where('is_active', true)->count();
        $totalOutlets = Outlet::where('is_active', true)->count();
        $totalProducts = Product::where('is_active', true)->count();
        $totalCategories = Category::where('is_active', true)->count();
        return view('admin.dashboard', compact('totalUsers', 'totalOutlets', 'totalProducts', 'totalCategories'));
    }
}
