<?php

namespace Mingalevme\Tests\Illuminate\Google\Laravel;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mingalevme\Illuminate\Google\LaravelGoogleServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../../vendor/laravel/laravel/bootstrap/app.php'; 

        $app->make(Kernel::class)->bootstrap();
        
        $app->register(LaravelGoogleServiceProvider::class);

        return $app;
    }
}
