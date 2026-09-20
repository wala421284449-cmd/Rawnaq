<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // استدعاء الـ Trait
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;
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
    public function scopeSearch(Builder $query, ?string $search): void
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }
    }

    // نطاق الفلترة حسب التصنيف
    public function scopeByCategory(Builder $query, $categoryId): void
    {
        if ($categoryId) {
            $query->where('categories_id', $categoryId);
        }
    }

    // نطاق الفلترة حسب السعر (من - إلى)
    public function scopePriceRange(Builder $query, $min, $max): void
    {
        if (!is_null($min)) {
            $query->where('base_price', '>=', $min);
        }
        if (!is_null($max)) {
            $query->where('base_price', '<=', $max);
        }
    }

    // نطاق الفرز والترتيب
    public function scopeSortProducts(Builder $query, ?string $sort): void
    {
        match ($sort) {
            'price_high' => $query->orderBy('base_price', 'desc'),
            'price_low'  => $query->orderBy('base_price', 'asc'),
            'oldest'     => $query->orderBy('created_at', 'asc'),
            default      => $query->orderBy('created_at', 'desc'), // الأحدث افتراضياً
        };
    }
}
