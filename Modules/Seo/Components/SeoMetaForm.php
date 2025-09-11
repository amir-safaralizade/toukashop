<?php

namespace Modules\Seo\Components;

use Illuminate\View\Component;
use Modules\Seo\Models\SeoMeta;
use Modules\Seo\Enums\SeoMetaKey;

class SeoMetaForm extends Component
{
    public string $model;
    public int $id;
    public array $seoKeys = [];
    public array $seoData = [];

    public function __construct($model, $id)
    {
        $this->model = get_class($model);
        $this->id = $id;

        $this->seoKeys = SeoMetaKey::cases();

        $this->seoData = SeoMeta::where('seoable_type', $this->model)
            ->where('seoable_id', $this->id)
            ->pluck('value', 'key')
            ->toArray();
    }

    public function render()
    {
        return view('seo::components.seo-meta-form');
    }
}
