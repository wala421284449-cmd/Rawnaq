<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductObserver
{
    /**
     * Handle the Product "deleting" event (قبل الحذف لتنظيف الملف المرتبط).
     */
    public function deleting(Product $product): void
    {
        // حذف الملف المرفق من التخزين تلقائياً عند حذف المنتج من أي مكان (Controller, API, Artisan)
        if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
            Storage::disk('public')->delete($product->main_image);
        }
    }

    /**
     * Handle the Product "updating" event (اختياري للتميز: حذف الصورة القديمة عند رفع صورة جديدة).
     */
    public function updating(Product $product): void
    {
        // التحقق مما إذا تم تغيير الصورة الرئيسية للمنتج
        if ($product->isDirty('main_image')) {
            $oldImage = $product->getOriginal('main_image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }
    }
}
