<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->bigInteger('postal_code')->unsigned()->nullable()->after('tracking_number');
            $table->string('shipping_province_id')->nullable()->after('postal_code')->references('id')->on('provinces');
            $table->string('shipping_city_id')->nullable()->after('shipping_province_id')->references('id')->on('cities');
            $table->string('shipping_address', 1000)->nullable()->after('shipping_city_id');
            $table->string('shipping_cost')->nullable()->after('shipping_address');

            $table->dropForeign(['order_id']);
            $table->bigInteger('order_id')->unsigned()->change();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unique('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropForeign(['shipping_province_id']);
            $table->dropForeign(['shipping_city_id']);
            $table->dropColumn(['postal_code', 'shipping_province_id', 'shipping_city_id', 'shipping_address', 'shipping_cost']);
            $table->dropForeign(['order_id']);
            $table->dropUnique(['order_id']);
            $table->bigInteger('order_id')->nullable()->change();
        });
    }
};
