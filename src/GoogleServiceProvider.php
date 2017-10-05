<?php

namespace Mingalevme\Illuminate\Google;

use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Configured?
     * 
     * @var mixed
     */
    protected $isConfigured = -1;

    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param  string  $path
     * @param  string  $key
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        if ($this->isConfigured === -1) {
            if ($this->app->getConfigurationPath('google')) {
                return ($this->isConfigured = $this->app->configure('google'));
            } else {
                return ($this->isConfigured = parent::mergeConfigFrom($path, $key));
            }
        } else {
            return $this->isConfigured;
        }
    }
    
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('google', function ($app) {
            $this->mergeConfigFrom(__DIR__.'/../config/google.php', 'google');
            return new GoogleManager($app);
        });

        $this->app->singleton('google.service', function ($app) {
            $this->mergeConfigFrom(__DIR__.'/../config/google.php', 'google');
            return $app['google']->service();
        });
    }
    
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
