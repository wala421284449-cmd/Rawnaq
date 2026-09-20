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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('rating', 45);
            $table->string('comment', 45);
            $table->string('is_approved', 45)->default('pending');
            $table->string('timestamps', 45)->nullable(); // إذا أردتِ الاحتفاظ به كما في رسمتك، أو يمكنك الاعتماد على timestamps() الافتراضية في لارايفل

            // المفاتيح الخارجية بناءً على المخطط
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('products_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('orders_id')->constrained('orders')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
