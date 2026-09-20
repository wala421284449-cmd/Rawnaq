<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_minutes',
        'is_available',
        'categories_id',
        'stores_id',
    ];

    /**
     * علاقة الخدمة بالتصنيف (كل خدمة تتبع تصنيفاً واحداً)
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    /**
     * علاقة الخدمة بالمتجر (كل خدمة تتبع متجراً واحداً)
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'stores_id');
    }
}
