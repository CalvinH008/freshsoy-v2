<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $fillable = [
        'product_variant_id', 'outlet_id', 'stock'
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
