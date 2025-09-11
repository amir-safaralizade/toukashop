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
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();

            $table->morphs('seoable'); // seoable_id + seoable_type

            $table->string('key');
            $table->text('value')->nullable();

            $table->timestamps();

            $table->unique(['seoable_id', 'seoable_type', 'key']); // یک کلید خاص فقط یک‌بار برای هر آبجکت
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};
