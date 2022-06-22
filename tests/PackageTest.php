<?php

namespace Mingalevme\Tests\Illuminate\Google;

use Exception;
use Mingalevme\Illuminate\Google\GoogleManager;
use Mingalevme\Illuminate\Google\Facades\Google;
use Mingalevme\Illuminate\Google\LumenGoogleServiceProvider;
use Mingalevme\Illuminate\Google\LaravelGoogleServiceProvider;

trait PackageTest
{
    public function testGetServiceWithoutDrive()
    {
        putenv('GOOGLE_SERVICE=Google_Service_Drive');
        putenv('GOOGLE_SCOPE=Google_Service_Drive');
        $this->app['config']->set('google', require __DIR__.'/../config/google.php');
        $this->app['google.config']->set('services.default.auth', [
            'type' => 'service_account',
            'client_id' => 'client_id',
            'client_email' => 'client_email',
            'private_key' => 'private_key',
        ]);
        $service = $this->app['google.service'];
        $this->assertInstanceOf('Google_Service_Drive', $service);
        $this->packageTearDown();
    }

    public function testGetServiceWithDrive()
    {
        putenv('GOOGLE_KEY_PATH=');
        $service = (new GoogleManager($this->app))->service('analytics');
        $this->assertInstanceOf('Google_Service_Analytics', $service);
        $this->packageTearDown();
    }

    public function testFacade()
    {
        putenv('GOOGLE_SERVICE=Google_Service_Drive');
        putenv('GOOGLE_SCOPE=Google_Service_Drive');
        $this->assertInstanceOf('Google_Client', Google::getClient());
        $this->packageTearDown();
    }

    public function testInvalidDriver()
    {
        try {
            (new GoogleManager($this->app))->service('exception');
            self::fail('Exception has not been thrown');
        } catch (Exception $e) {
            self::assertInstanceOf('InvalidArgumentException', $e);
        }
        $this->packageTearDown();
    }

    public function testInvalidService()
    {
        try {
            (new GoogleManager($this->app))->service();
            self::fail('Exception has not been thrown');
        } catch (Exception $e) {
            self::assertInstanceOf('InvalidArgumentException', $e);
        }
        $this->packageTearDown();
    }

    public function testInvalidScope()
    {
        putenv('GOOGLE_KEY_PATH=');
        putenv('GOOGLE_SERVICE=Google_Service_Drive');
        try {
            (new GoogleManager($this->app))->service();
            self::fail('Exception has not been thrown');
        } catch (Exception $e) {
            self::assertInstanceOf('InvalidArgumentException', $e);
        }
        $this->packageTearDown();
    }

    public function testProvides()
    {
        putenv('GOOGLE_KEY_PATH=');
        putenv('GOOGLE_SERVICE=Google_Service_Drive');
        $provides = [
            'google', 'google.service', 'google.config',
        ];
        $this->assertSame($provides, (new LaravelGoogleServiceProvider($this->app))->provides());
        $this->assertSame($provides, (new LumenGoogleServiceProvider($this->app))->provides());
        $this->packageTearDown();
    }

    /*
     * self::tearDown() requires ": void" return type since some PHPUnit version
     */
    protected function packageTearDown()
    {
        putenv('GOOGLE_SCOPE');
        putenv('GOOGLE_SERVICE');
    }
}
