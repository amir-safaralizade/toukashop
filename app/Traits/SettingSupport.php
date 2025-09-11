<?php

namespace App\Traits;

use App\Services\SettingService;

trait SettingSupport
{
    protected SettingService $settingService;

    public function initSettingSupport()
    {
        $this->settingService = app(SettingService::class);
    }

    public function setting(string $key, mixed $default = null): mixed
    {
        return $this->settingService->get($key, $default);
    }

    public function setSetting(string $key, mixed $value): bool
    {
        return $this->settingService->set($key, $value);
    }

    public function allSettings(): array
    {
        return $this->settingService->all();
    }
}
