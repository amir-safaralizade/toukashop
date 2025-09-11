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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            $table->string('gateway');            // مثلا: zarinpal
            $table->string('ref_id')->nullable(); // کد رهگیری درگاه
            $table->unsignedBigInteger('amount'); // مبلغ به تومان
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');

            $table->string('description')->nullable(); // مثلا: پرداخت سفارش #245
            $table->json('raw_response')->nullable();  // ذخیره پاسخ کامل درگاه

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
