<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    /** @use HasFactory<\Database\Factories\OfferFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'discount_percentage',
        'sale_price',
        'start_date',
        'end_date',
        'is_active',
        'stores_id',
        'products_id',
    ];

    /**
     * علاقة العرض بالمتجر
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'stores_id');
    }

    /**
     * علاقة العرض بالمنتج
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
