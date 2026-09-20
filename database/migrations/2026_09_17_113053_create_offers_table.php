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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title', 45);
            $table->decimal('discount_percentage', 5, 2)->nullable(); // نسبة الخصم مثلاً 20.00%
            $table->decimal('sale_price', 10, 2); // السعر بعد الخصم
            $table->date('start_date');
            $table->date('end_date');

            // حالة العرض
            $table->enum('is_active', ['active', 'inactive'])->default('active');

            // المفاتيح الخارجية
            $table->foreignId('stores_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignId('products_id')->constrained('products')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
