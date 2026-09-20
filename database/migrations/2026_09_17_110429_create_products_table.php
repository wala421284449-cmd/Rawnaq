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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('sku', 45)->unique();
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->string('main_image', 255)->nullable();

            // حالة المنتج (نشط / غير نشط)
            $table->enum('is_active', ['active', 'inactive'])->default('active');

            // المفاتيح الخارجية للربط مع المتاجر والتصنيفات
            $table->foreignId('stores_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignId('categories_id')->constrained('categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
