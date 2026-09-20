<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'bookings_or_orderscol',
        'type',
        'total_amount',
        'status',
        'booking_date',
        'completed_at',
        'stores_id',
        'user_id',
    ];
    public function store()
    {
        return $this->belongsTo(Store::class, 'stores_id');
    }

    /**
     * علاقة الطلب بالمستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'orders_id');
    }
    public function review()
    {
        return $this->hasOne(Review::class, 'orders_id');
    }
}
