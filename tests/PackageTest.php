<?php

namespace Mingalevme\Tests\Illuminate\Google;

use Mingalevme\Illuminate\Google\GoogleManager;
use Mingalevme\Illuminate\Google\Facades\Google;
use Mingalevme\Illuminate\Google\LumenGoogleServiceProvider;
use Mingalevme\Illuminate\Google\LaravelGoogleServiceProvider;

trait PackageTest
{
    /**
     * @test
     */
    public function testGetServiceWithoutDrive()
    {
        putenv('GOOGLE_SERVICE=Google_Service_Drive');
        putenv('GOOGLE_SCOPE=Google_Service_Drive');
        
        $this->app['google.config']->set('services.default.auth', [
            'type' => 'service_account',
            'client_id' => 'client_id',
            'client_email' => 'client_email',
            'private_key' => 'private_key',
        ]);
        
        $service = $this->app['google.service'];
        
        $this->assertInstanceOf('Google_Service_Drive', $service);
    }
    
    /**
     * @test
     */
    public function testGetServiceWithDrive()
    {
        putenv('GOOGLE_KEY_PATH=');
        $service = (new GoogleManager($this->app))->service('analytics');
        $this->assertInstanceOf('Google_Service_Analytics', $service);
    }
    
    public function testFacade()
    {
        putenv('GOOGLE_SERVICE=Google_Service_Drive');
        putenv('GOOGLE_SCOPE=Google_Service_Drive');
        $this->assertInstanceOf('Google_Client', Google::getClient());
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDriver()
    {
        (new GoogleManager($this->app))->service('exception');
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidService()
    {
        (new GoogleManager($this->app))->service();
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidScope()
    {
        putenv('GOOGLE_KEY_PATH=');
        putenv('GOOGLE_SERVICE=Google_Service_Drive');
        (new GoogleManager($this->app))->service();
    }
    
    /**
     * @test
     */
    public function testProvides()
    {
        putenv('GOOGLE_KEY_PATH=');
        putenv('GOOGLE_SERVICE=Google_Service_Drive');
        $provides = [
            'google', 'google.service', 'google.config',
        ];
        $this->assertSame($provides, (new LaravelGoogleServiceProvider($this->app))->provides());
        $this->assertSame($provides, (new LumenGoogleServiceProvider($this->app))->provides());
    }
    
    public function tearDown()
    {
        putenv('GOOGLE_SCOPE');
        putenv('GOOGLE_SERVICE');
        parent::tearDown();
    }
}
