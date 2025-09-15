<?php

namespace App\Models;

use App\Traits\HasMediaFiles;
use Illuminate\Database\Eloquent\Model;
use Modules\Visit\Traits\Visitable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasMediaFiles, Visitable, LogsActivity;

    protected $fillable = ['title', 'content', 'slug', 'user_id', 'category_id'];

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

    protected static function booted(): void
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', 'published'); // یا 1
        });
    }

    // ارتباط با کاربر
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->where('type', 'post');
    }
}
