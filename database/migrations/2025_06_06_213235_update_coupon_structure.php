<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            // افزودن ستون نوع کوپن
            $table->enum('type', ['fixed', 'percent'])->after('code')->default('fixed');

            // تغییر نوع discount_amount به unsignedBigInteger
            $table->unsignedBigInteger('discount_amount')->nullable()->change();

            // تغییر نوع discount_percent (دقت کمتر ولی کفایت می‌کنه)
            $table->decimal('discount_percent', 5, 2)->nullable()->change();

            // افزودن حداقل مبلغ سفارش
            $table->unsignedBigInteger('min_order_amount')->nullable()->after('discount_percent');

            // افزودن محدودیت استفاده و تعداد استفاده‌شده
            $table->unsignedInteger('usage_limit')->nullable()->after('min_order_amount');
            $table->unsignedInteger('used_count')->default(0)->after('usage_limit');

            // افزودن عنوان نمایشی برای کوپن
            $table->string('title')->nullable()->after('code');
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'min_order_amount',
                'usage_limit',
                'used_count',
                'title',
            ]);

            // بازگرداندن نوع discount_amount به decimal
            $table->decimal('discount_amount', 12, 2)->nullable()->change();
        });
    }
};
