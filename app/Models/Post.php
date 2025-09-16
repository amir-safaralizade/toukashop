<?php

namespace App\Models;

use App\Traits\HasMediaFiles;
use Illuminate\Database\Eloquent\Model;
use Modules\Visit\Traits\Visitable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

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

    public function getSummaryAttribute()
    {
        // Remove HTML tags and limit to 100 characters
        return Str::limit(strip_tags($this->content), 100);
    }



    /**
     * Estimate reading time in minutes (rounded up).
     *
     * @param int $wordsPerMinute Reading speed (words per minute). Default 200.
     * @param int $secondsPerImage Extra seconds to add per image. Default 12.
     * @return int Minutes (integer, at least 1)
     */
    public function estimateReadingMinutes(int $wordsPerMinute = 200, int $secondsPerImage = 12): int
    {
        // Strip tags and decode HTML entities
        $text = html_entity_decode(strip_tags($this->content), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // normalize whitespace
        $text = preg_replace('/\s+/u', ' ', trim($text));

        if ($text === '') {
            return 0;
        }

        // Count words (multibyte safe)
        // Split on whitespace; works for Persian and other languages
        $words = preg_split('/\s+/u', $text);
        $wordCount = is_array($words) ? count($words) : 0;

        // Count <img> tags in original content to add extra seconds per image
        preg_match_all('/<img\b[^>]*>/i', $this->content ?? '', $imgMatches);
        $imageCount = isset($imgMatches[0]) ? count($imgMatches[0]) : 0;

        // Total seconds = reading time by words + extra for images
        // Calculate seconds per words:
        $secondsForWords = ($wordCount / max(1, $wordsPerMinute)) * 60;
        $secondsForImages = $imageCount * $secondsPerImage;

        $totalSeconds = (int) ceil($secondsForWords + $secondsForImages);

        // convert to minutes, round up to nearest whole minute (or return 1 if >0)
        $minutes = (int) ceil($totalSeconds / 60);

        return $minutes > 0 ? $minutes : 0;
    }

    /**
     * Human friendly reading time text.
     *
     * @param int $wordsPerMinute
     * @param int $secondsPerImage
     * @param bool $usePersianDigits If true, convert digits to Persian numerals in the returned string.
     * @return string e.g. "۳ دقیقه" or "1 minute"
     */
    public function readingTimeText(int $wordsPerMinute = 200, int $secondsPerImage = 12, bool $usePersianDigits = true): string
    {
        $minutes = $this->estimateReadingMinutes($wordsPerMinute, $secondsPerImage);

        if ($minutes === 0) {
            $text = 'کمتر از 1 دقیقه';
            return $usePersianDigits ? $this->toPersianDigits($text) : $text;
        }

        // Persian phrasing: "X دقیقه"
        $text = $minutes . ' دقیقه';

        return $usePersianDigits ? $this->toPersianDigits($text) : $text;
    }

    /**
     * Convert Western digits in a string to Persian digits.
     *
     * @param string $input
     * @return string
     */
    protected function toPersianDigits(string $input): string
    {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return str_replace($western, $persian, $input);
    }

    /**
     * Eloquent accessor to use as $post->reading_time_minutes
     *
     * @return int
     */
    public function getReadingTimeMinutesAttribute(): int
    {
        return $this->estimateReadingMinutes();
    }

    /**
     * Eloquent accessor to use as $post->reading_time_text
     *
     * @return string
     */
    public function getReadingTimeTextAttribute(): string
    {
        return $this->readingTimeText();
    }
}
