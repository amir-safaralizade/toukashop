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
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();

            $table->morphs('fileable'); // fileable_id, fileable_type

            $table->string('type')->nullable(); // image, video, document, audio, etc.
            $table->string('path');             // مسیر فایل
            $table->string('disk')->default('public'); // برای پشتیبانی از multiple disks
            $table->string('mime')->nullable(); // image/png, application/pdf
            $table->string('original_name')->nullable();
            $table->string('title')->nullable();     // برای سئو
            $table->string('alt')->nullable();       // برای تصاویر
            $table->string('group')->nullable();     // مانند: "gallery", "thumbnail", "avatar"

            $table->unsignedBigInteger('uploaded_by')->nullable(); // کاربر آپلودکننده
            $table->ipAddress('uploaded_ip')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};
