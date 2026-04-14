<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $fillable = [
        'name', 'code', 'address', 'phone', 'is_active'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function productStocks()
    {
        return $this->hasMany(ProductStock::class);
    }
}
