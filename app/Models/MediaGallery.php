<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaGallery extends Model
{
    /** @use HasFactory<\Database\Factories\MediaGalleryFactory> */
    use HasFactory;
    protected $fillable = [
        'file_path',
        'media_type',
        'title',
        'sort_order',
        'stores_id',
    ];
    public function store()
    {
        return $this->belongsTo(Store::class, 'stores_id');
    }
}
