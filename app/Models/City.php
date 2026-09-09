<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class, 'cities_id', 'id');
    }
}
