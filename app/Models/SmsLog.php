<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'to', 'message', 'template_id', 'parameters', 'status', 'provider', 'error', 'sent_at',
    ];

    protected $casts = [
        'parameters' => 'array',
        'sent_at' => 'datetime',
    ];
}
