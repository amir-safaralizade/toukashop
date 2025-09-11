<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    protected $table = 'seo_metas';

    protected $fillable = ['seoable_id', 'seoable_type', 'key', 'value'];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
