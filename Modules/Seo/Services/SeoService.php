<?php

namespace Modules\Seo\Services;

use Modules\Seo\Models\SeoMeta;

class SeoService
{
    public function loadSeoData(string $modelClass, int $modelId): array
    {
        return SeoMeta::where('seoable_type', $modelClass)
            ->where('seoable_id', $modelId)
            ->pluck('value', 'key')
            ->toArray();
    }

    public function saveSeoData(string $modelClass, int $modelId, array $data): void
    {
        $filtered = array_filter($data, fn ($value) => !is_null($value) && $value !== '');

        foreach ($filtered as $key => $value) {
            SeoMeta::updateOrCreate(
                [
                    'seoable_type' => $modelClass,
                    'seoable_id' => $modelId,
                    'key' => $key
                ],
                [
                    'value' => $value
                ]
            );
        }
    }
}
