<?php

namespace Modules\Seo\Components;

use Illuminate\View\Component;
use Modules\Seo\Models\SeoMeta;
use Modules\Seo\Enums\SeoMetaKey;

class SeoMetaDisplay extends Component
{
    public $model;
    public array $seoData;

    public function __construct($model)
    {
        $this->model = $model;

        $this->seoData = SeoMeta::where('seoable_type', get_class($model))
            ->where('seoable_id', $model->id)
            ->pluck('value', 'key')
            ->toArray();
    }

    public function get(SeoMetaKey $key, $default = null)
    {
        return $this->seoData[$key->value] ?? $this->fallback($key) ?? $default;
    }

    public function fallback(SeoMetaKey $key)
    {
        $fallbacks = config('seo.fallbacks');
        $keyName = $key->value;

        if (!isset($fallbacks[$keyName])) {
            return null;
        }

        $fields = (array) $fallbacks[$keyName];

        foreach ($fields as $field) {
            if (!empty($this->model->{$field})) {
                return $this->model->{$field};
            }
        }

        return null;
    }

    public function render()
    {
        return view('seo::components.seo-meta-display');
    }
}
