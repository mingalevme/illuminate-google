<?php

namespace Mingalevme\Tests\Illuminate\Google\Lumen;

use Laravel\Lumen\Testing\TestCase as LumenTestCase;
use Mingalevme\Illuminate\Google\LumenGoogleServiceProvider;

abstract class TestCase extends LumenTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $app = new \Laravel\Lumen\Application(
            realpath(__DIR__.'/../../vendor/laravel/lumen')
        );
        
        $app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Laravel\Lumen\Exceptions\Handler::class
        );

        $app->singleton(
            \Illuminate\Contracts\Console\Kernel::class,
            \Laravel\Lumen\Console\Kernel::class
        );
        
        $app->withFacades();
        
        $app->register(LumenGoogleServiceProvider::class);
        
        return $app;
    }
}
