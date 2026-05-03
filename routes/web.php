<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\OutletController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboard;
use App\Http\Controllers\Cashier\DashboardController as CashierDashboard;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Inventory\DashboardController as InventoryDashboard;
use App\Http\Controllers\Manager\ProductController as ManagerProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // dashboard admin
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    // crud user
    Route::resource('/users', UserController::class)->except(['show']);
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle');
    // crud outlet
    Route::resource('/outlets', OutletController::class)->except(['show']);
    Route::patch('outlets/{outlet}/toggle', [OutletController::class, 'toggleStatus'])->name('outlets.toggle');
    // crud category
    Route::resource('/categories', CategoryController::class)->except(['show']);
    Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle');
    // crud product
    Route::resource('/products', ProductController::class)->except(['show']);
    Route::patch('/products/{product}/toggle', [ProductController::class, 'toggleStatus'])->name('products.toggle');
    // stock management
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::put('/stocks', [StockController::class, 'update'])->name('stocks.update');
});

Route::prefix('manager')->name('manager.')->middleware(['auth', 'role:manager'])->group(function () {
    // dashboard manager
    Route::get('/dashboard', [ManagerDashboard::class, 'index'])->name('dashboard');
    // view produk manager
    Route::get('/products', [ManagerProductController::class, 'index'])->name('products.index');
});

Route::prefix('inventory')->name('inventory.')->middleware(['auth', 'role:inventory'])->group(function () {
    Route::get('/dashboard', [InventoryDashboard::class, 'index'])->name('dashboard');
});

Route::prefix('cashier')->name('cashier.')->middleware(['auth', 'role:cashier'])->group(function () {
    Route::get('/pos', [CashierDashboard::class, 'index'])->name('pos');
});