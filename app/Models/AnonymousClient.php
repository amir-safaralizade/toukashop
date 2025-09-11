<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnonymousClient extends Model
{
    protected $fillable = [
        'uuid', 'last_ip', 'user_agent'
    ];
}
