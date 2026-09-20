<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;
    protected $fillable = [
        'bookings_or_orders_id',
        'products_id',
        'quantity',
        'price',
    ];

    /**
     * علاقة عنصر الطلب بالطلب الرئيسي
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    /**
     * علاقة عنصر الطلب بالمنتج نفسه
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
