<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $fillable = ['attribute_id', 'value'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function getDisplayValueAttribute(): string
    {
        if (!preg_match('/^#(?:[A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $this->value)) {
            return $this->value;
        }

        $colorNames = [
            '#FF0000' => 'قرمز', '#8B0000' => 'قرمز تیره', '#0000FF' => 'آبی',
            '#00008B' => 'آبی تیره', '#87CEEB' => 'آبی آسمانی', '#00FF00' => 'سبز',
            '#006400' => 'سبز تیره', '#808000' => 'زیتونی', '#000000' => 'مشکی',
            '#FFFFFF' => 'سفید', '#FFA500' => 'نارنجی', '#800080' => 'بنفش',
            '#9370DB' => 'بنفش روشن', '#FF69B4' => 'صورتی', '#FF1493' => 'صورتی تیره',
            '#FFD700' => 'طلایی', '#C0C0C0' => 'نقره‌ای', '#A52A2A' => 'قهوه‌ای',
            '#808080' => 'خاکستری', '#FFFF00' => 'زرد', '#00CED1' => 'فیروزه‌ای',
            '#4B0082' => 'نیلی', '#FFFDD0' => 'کرم', '#B87333' => 'مسی',
            '#CD7F32' => 'برنزی', '#F5DEB3' => 'نخودی', '#A9A9A9' => 'طوسی',
            '#90EE90' => 'سبز روشن', '#ADD8E6' => 'آبی روشن', '#FF6B6B' => 'قرمز روشن',
            '#800020' => 'شرابی', '#1A1A4E' => 'سورمه‌ای', '#556B2F' => 'سبز زیتونی',
            '#FFBF00' => 'زرد کهربایی', '#EAE0C8' => 'مرواریدی',
        ];

        return $colorNames[strtoupper($this->value)] ?? 'رنگ انتخابی';
    }
}
