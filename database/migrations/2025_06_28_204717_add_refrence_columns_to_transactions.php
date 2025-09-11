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
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('our_token')->nullable()->after('ref_id');
            $table->string('Authority')->nullable()->after('our_token'); // Zarinpal authority code
            $table->ipAddress('request_ip')->nullable()->after('Authority');
            $table->ipAddress('verify_ip')->nullable()->after('request_ip');
            $table->string('card_pan')->nullable()->after('verify_ip');
            $table->string('card_hash')->nullable()->after('card_pan');
            $table->string('fee_type')->nullable()->after('card_hash'); // e.g. "merchant"
            $table->unsignedBigInteger('fee')->nullable()->after('fee_type'); // transaction fee (Toman)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'our_token',
                'Authority',
                'request_ip',
                'verify_ip',
                'card_pan',
                'card_hash',
                'fee_type',
                'fee',
            ]);
        });
    }
};
