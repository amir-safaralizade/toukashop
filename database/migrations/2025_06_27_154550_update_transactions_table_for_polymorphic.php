<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // حذف کلید خارجی order_id
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');

            // افزودن فیلدهای polymorphic
            $table->unsignedBigInteger('payable_id');
            $table->string('payable_type');

            // افزودن ایندکس جهت سرعت در query
            $table->index(['payable_type', 'payable_id']);
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // حذف فیلدهای polymorphic
            $table->dropIndex(['payable_type', 'payable_id']);
            $table->dropColumn(['payable_id', 'payable_type']);

            // بازگرداندن order_id
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
        });
    }
};
