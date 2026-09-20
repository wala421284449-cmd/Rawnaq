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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('description', 45)->nullable();
            $table->string('price', 45);
            $table->string('duration_minutes', 45);

            // جعل الحالة enum بقيم محددة (متوفر / غير متوفر)
            $table->enum('is_available', ['available', 'unavailable'])->default('available');

            // العلاقات الخارجية
            $table->foreignId('categories_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('stores_id')->constrained('stores')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
