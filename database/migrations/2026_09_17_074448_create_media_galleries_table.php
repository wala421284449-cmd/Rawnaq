<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');                    // مسار الصورة أو الملف
            $table->string('media_type')->nullable();       // نوع الوسائط (مثلاً: gallery, banner, etc.)
            $table->string('title')->nullable();            // عنوان الصورة أو الوصف المختصر
            $table->string('sort_order')->nullable();       // ترتيب العرض

            // المفتاح الأجنبي المرتبط بجدول المتاجر stores
            $table->foreignId('stores_id')->constrained('stores')->onDelete('cascade'); // إذا تم حذف المتجر، يتم حذف صوره تلقائياً
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_galleries');
        
    }
};
