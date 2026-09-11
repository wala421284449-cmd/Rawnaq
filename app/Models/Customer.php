<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'id_number',
        'whats_up_number',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'actor');
    }
}
