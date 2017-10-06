<?php

namespace Mingalevme\Illuminate\Google;

class LaravelGoogleServiceProvider extends GoogleServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/google.php'
                => $this->app->basePath() . '/config/google.php',
        ], 'config');
    }
}
