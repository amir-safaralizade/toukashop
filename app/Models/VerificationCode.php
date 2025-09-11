<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $fillable = [
        'phone', 'code', 'channel', 'verified', 'attempts', 'expires_at'
    ];

    protected $casts = [
        'verified' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public $timestamps = true;

    public static function generate(string $phone, string $channel = 'sms'): self
    {
        return self::create([
            'phone' => $phone,
            'code' => str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'channel' => $channel,
            'expires_at' => now()->addMinutes(3),
        ]);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
