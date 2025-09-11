<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupon_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete(); // در صورت وجود سفارش

            $table->unsignedInteger('used_count')->default(1);
            $table->timestamp('used_at')->useCurrent();

            $table->unique(['coupon_id', 'user_id', 'order_id']); // برای جلوگیری از تکراری بودن
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_user');
    }
};
