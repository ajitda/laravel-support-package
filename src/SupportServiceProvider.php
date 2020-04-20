<?php

namespace Flexibleit\Support;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'support');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->mergeConfigFrom(__DIR__.'/config/support.php', 'support');
        $this->registerHelpers();
        $this->publishes([
            __DIR__.'/config/support.php' => config_path('support.php')
        ]);
    }

    public function register()
    {

    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        // Load the helpers in app/Http/helpers.php
        if (file_exists($file = __DIR__.'/Http/Helpers/helpers.php'))
        {
            require $file;
        }
    }
}