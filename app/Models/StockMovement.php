<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'product_variant_id',
        'user_id',
        'outlet_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'reference',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
