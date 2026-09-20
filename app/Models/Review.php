<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;
    protected $fillable = [
        'rating',
        'comment',
        'is_approved',
        'timestamps',
        'user_id',
        'products_id',
        'orders_id',
    ];

    /**
     * علاقة التقييم بالمستخدم صاحب التقييم
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * علاقة التقييم بالمنتج
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    /**
     * علاقة التقييم بالطلب
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }
}
