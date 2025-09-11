<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Post extends Model
{
    use LogsActivity;

    protected $fillable = ['title', 'content', 'user_id'];

    // تنظیمات لاگ‌گیری
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'content']) // فقط این ویژگی‌ها ثبت شوند
            ->logOnlyDirty() // فقط تغییرات ثبت شوند
            ->dontSubmitEmptyLogs() // لاگ خالی ثبت نشود
            ->setDescriptionForEvent(function (string $eventName) {
                return match ($eventName) {
                    'created' => "پست جدید ایجاد شد",
                    'updated' => "پست به‌روزرسانی شد",
                    'deleted' => "پست حذف شد",
                    default => "فعالیت روی پست: {$eventName}",
                };
            });
    }

    // ارتباط با کاربر
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
