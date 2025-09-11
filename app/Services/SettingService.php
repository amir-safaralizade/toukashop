<?php
namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    protected $cacheKey = 'site_settings';

    public function all(): array
    {
        return Cache::rememberForever($this->cacheKey, function () {
            return Setting::all()
                ->groupBy('group')
                ->mapWithKeys(function ($items, $group) {
                    return [$group => $items->mapWithKeys(fn($item) => [$item->key => $item->getCastValue()])];
                })->toArray();
        });
    }

    public function get(string $key, $default = null)
    {
        $settings = $this->all();
        [$group, $subKey] = explode('.', $key) + [null, null];
        return isset($settings[$group][$subKey]) ? $settings[$group][$subKey] : $default;
    }

    public function set(string $key, $value): void
    {
        [$group, $subKey] = explode('.', $key) + [null, null];
        Setting::updateOrCreate(
            ['group' => $group, 'key' => $subKey],
            ['value' => is_array($value) ? json_encode($value) : ($value === null ? null : (is_bool($value) ? json_encode($value) : $value))]
        );
        $this->forgetCache();
    }

    public function forgetCache(): void
    {
        Cache::forget($this->cacheKey);
    }
}
