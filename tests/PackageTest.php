<?php

namespace Mingalevme\Tests\Illuminate\Google;

use Mingalevme\Illuminate\Google\GoogleManager;
use Mingalevme\Illuminate\Google\Facades\Google;

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
        
        $manager = new GoogleManager($this->app);
        
        $service = $manager->service();
        
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
        putenv('GOOGLE_SCOPE=Google_Service_Drive');
        putenv('GOOGLE_SERVICE=Google_Service_Drive');
        $this->assertInstanceOf('Google_Client', Google::getClient());
    }
    
    public function tearDown()
    {
        putenv('GOOGLE_SCOPE');
        putenv('GOOGLE_SERVICE');
        parent::tearDown();
    }
}
