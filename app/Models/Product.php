<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // استدعاء الـ Trait

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'sku',
        'description',
        'base_price',
        'stock_quantity',
        'main_image',
        'is_active',
        'stores_id',
        'categories_id',
    ];
    public function store()
    {
        return $this->belongsTo(Store::class, 'stores_id');
    }

    /**
     * علاقة المنتج بالتصنيف (المنتج ينتمي لتصنيف واحد)
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
    public function offers()
    {
        return $this->hasMany(Offer::class, 'products_id');
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'products_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'products_id');
    }
}
