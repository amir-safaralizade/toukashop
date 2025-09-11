<?php

namespace Modules\Seo;

use Illuminate\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/Config/seo.php', 'seo');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'seo');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        \Illuminate\Support\Facades\Blade::componentNamespace(
            'Modules\\Seo\\Components',
            'seo'
        );
    }

}
