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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 45);
            $table->string('customer_phone', 45);
            $table->string('bookings_or_orderscol', 45)->nullable();
            $table->string('type', 45);
            $table->decimal('total_amount', 10, 2);
            $table->string('status', 45)->default('pending');
            $table->date('booking_date')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->foreignId('stores_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
