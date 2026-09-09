<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'owners';

    protected $fillable = [
        'id_number',
        'whats_up_number',
    ];

    /**
     * علاقة الـ Polymorphic المعاكسة للمستخدم
     */
    public function user()
    {
        return $this->morphOne(User::class, 'actor');
    }
}
