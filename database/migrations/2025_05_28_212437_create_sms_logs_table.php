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
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('to'); // شماره مقصد
            $table->text('message')->nullable(); // متن پیامک (در صورت وجود)
            $table->string('template_id')->nullable(); // برای پیامک‌های قالبی
            $table->json('parameters')->nullable(); // متغیرهای ارسال‌شده
            $table->string('status')->default('pending'); // pending, sent, failed
            $table->string('provider')->nullable(); // مثلاً sms.ir
            $table->text('error')->nullable(); // اگر خطایی بود
            $table->timestamp('sent_at')->nullable(); // زمان واقعی ارسال
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
