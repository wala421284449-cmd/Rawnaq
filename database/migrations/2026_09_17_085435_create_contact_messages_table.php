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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('phone_or_email', 45);
            $table->string('subject', 45);
            $table->text('message'); // تم جعلها text لتأخذ براحته في حال كانت الرسالة طويلة

            // حالة القراءة بصيغة Enum (تحديد الحالات المسموحة بدقة)
            $table->enum('is_read', ['unread', 'read', 'replied'])->default('unread');

            // العلاقات (Foreign Keys) مع المتاجر والمستخدمين
            $table->foreignId('stores_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
