<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'type',
    ];
    // توليد الـ slug تلقائياً من الاسم إذا لم يتم إدخاله
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'categories_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'categories_id');
    }
}
