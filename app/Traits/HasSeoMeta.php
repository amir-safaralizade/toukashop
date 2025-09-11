<?php

namespace App\Traits;

use App\Models\SeoMeta;

trait HasSeoMeta
{
    public function seoMeta()
    {
        return $this->morphMany(SeoMeta::class, 'seoable');
    }

    public function getSeoValue(string $key, $default = null)
    {
        return optional($this->seoMeta->where('key', $key)->first())->value ?? $default;
    }

    public function setSeoValue(string $key, $value)
    {
        $this->seoMeta()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public function deleteSeoKey(string $key)
    {
        $this->seoMeta()->where('key', $key)->delete();
    }

    public function allSeoMetaAsArray()
    {
        return $this->seoMeta->pluck('value', 'key')->toArray();
    }
}
