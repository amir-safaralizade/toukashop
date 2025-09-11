<?php

namespace Modules\Visit\Entities;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'user_id',
        'visited_at',
    ];

    public function visitable()
    {
        return $this->morphTo();
    }
}
