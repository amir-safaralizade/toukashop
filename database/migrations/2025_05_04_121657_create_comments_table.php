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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // ارتباط با مدل هدف (پست، محصول، ...)
            $table->morphs('commentable'); // commentable_id + commentable_type

            // نویسنده کامنت (کاربر، ادمین، مهمان و ...)
            $table->unsignedBigInteger('author_id')->nullable();
            $table->string('author_type')->nullable();

            // کامنت والد برای درختی بودن
            $table->unsignedBigInteger('parent_id')->nullable()->index();

            $table->text('content');

            // اطلاعات مدیریت و بررسی
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('moderated_at')->nullable();
            $table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();

            // اطلاعات فنی کاربر
            $table->ipAddress('ip_address')->nullable();
            $table->string('session_id')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
