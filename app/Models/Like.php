<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{
    protected $fillable = [
        'likeable_id',
        'likeable_type',
        'liker_id',
        'liker_type',
        'guest_token',
        'ip',
    ];

    /**
     * مدل لایک‌شده (Post, Comment, etc.)
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * موجودیت لایک‌کننده (User, Guest, etc.)
     */
    public function liker(): MorphTo
    {
        return $this->morphTo();
    }
}
