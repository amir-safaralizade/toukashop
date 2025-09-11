<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    protected $fillable = ['key', 'value'];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
