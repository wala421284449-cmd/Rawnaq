<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /** @use HasFactory<\Database\Factories\StoreFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'cover_image',
        'whatsapp_number',
        'status',
        'user_id',
        'address_id',
    ];

    /**
     * علاقة المتجر بالمستخدم (المالك)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة المتجر بالعنوان
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function mediaGalleries()
    {
        return $this->hasMany(MediaGallery::class, 'stores_id');
    }
    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class, 'stores_id');
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'stores_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'stores_id');
    }
    public function offers()
    {
        return $this->hasMany(Offer::class, 'stores_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'stores_id');
    }
}
