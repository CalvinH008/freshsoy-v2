<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function (){
    Route::get('/dashboard', function (){
        return 'admin dashboard';
    })->name('dashboard');
});

Route::prefix('manager')->name('manager.')->middleware('role:manager')->group(function (){
    Route::get('/dashboard', function (){
        return 'manager dashboard';
    })->name('dashboard');
});

Route::prefix('cashier')->name('cashier.')->middleware('role:cashier')->group(function (){
    Route::get('/pos', function (){
        return 'pos dashboard';
    })->name('pos');
});