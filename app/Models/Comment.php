<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'commentable_id', 'commentable_type',
        'author_id', 'author_type',
        'parent_id', 'content',
        'status', 'moderated_at', 'moderated_by', 'rejection_reason',
        'ip_address', 'session_id', 'user_agent',
    ];

    protected $casts = [
        'moderated_at' => 'datetime',
    ];

    // وضعیت‌ها به صورت ثابت
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // ارتباط با پست یا محصول یا ... (commentable)
    public function commentable()
    {
        return $this->morphTo();
    }

    // نویسنده کامنت (کاربر، ادمین، ...)
    public function author()
    {
        return $this->morphTo();
    }

    // پاسخ‌ها (کامنت‌های فرزند)
    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // کامنت والد
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // کاربر بررسی‌کننده
    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    // وضعیت‌ها به صورت متد کمکی
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }
}
