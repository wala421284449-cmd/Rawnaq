<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    /** @use HasFactory<\Database\Factories\ContactMessageFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'phone_or_email',
        'subject',
        'message',
        'is_read',
        'stores_id',
        'user_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'stores_id');
    }

    /**
     * العلاقة مع المستخدم (إن وجد)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
