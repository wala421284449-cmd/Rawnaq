<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;
    protected $fillable = [
        'area',
        'street',
        'building_details',
        'latitude',
        'longitude',
        // 'stores_id',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'addresses_id', 'id');
    }
}
