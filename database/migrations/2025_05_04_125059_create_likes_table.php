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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();

            $table->morphs('likeable');

            // liker_id و liker_type دستی تا nullable باشه
            $table->unsignedBigInteger('liker_id')->nullable();
            $table->string('liker_type')->nullable();
            $table->index(['liker_id', 'liker_type']);

            $table->uuid('guest_token')->nullable();
            $table->ipAddress('ip')->nullable();

            $table->timestamps();

            // جلوگیری از لایک دوباره
            $table->unique(['likeable_id', 'likeable_type', 'liker_id', 'liker_type']);
            $table->unique(['likeable_id', 'likeable_type', 'guest_token']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
