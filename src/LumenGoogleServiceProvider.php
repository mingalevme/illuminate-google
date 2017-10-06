<?php

namespace Mingalevme\Illuminate\Google;

class LumenGoogleServiceProvider extends GoogleServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->app->configure('google');
    }
}
