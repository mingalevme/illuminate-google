<?php

namespace Mingalevme\Illuminate\Google;

use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;

abstract class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('google.config', function ($app) {
            return $app['config']['google']
                    ? new Repository($app['config']['google'])
                    : new Repository(require __DIR__.'/../config/google.php');
        });
        
        $this->app->singleton('google', function ($app) {
            return new GoogleManager($app);
        });

        $this->app->singleton('google.service', function ($app) {
            return $app['google']->service();
        });
    }
    
    /**
     * Boot the service provider.
     */
    abstract public function boot();

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'google', 'google.service',
        ];
    }
}
