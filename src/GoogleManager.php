<?php

namespace Mingalevme\Illuminate\Google;

use InvalidArgumentException;

class GoogleManager
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The array of resolved services.
     *
     * @var array
     */
    protected $services = [];
    
    /**
     * Create a new Google manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Get a Google service instance by name.
     *
     * @param  string|null  $name
     * @return \Google_Service
     */
    public function service($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();
        
        return $this->services[$name] = $this->get($name);
    }

    /**
     * Attempt to get the service from the local cache.
     *
     * @param  string  $name
     * @return \Google_Service
     */
    protected function get($name)
    {
        return isset($this->services[$name]) ? $this->services[$name] : $this->resolve($name);
    }

    /**
     * Resolve the given service.
     *
     * @param  string  $name
     * @return \Google_Service
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);
        
        if (is_null($config)) {
            throw new InvalidArgumentException("Google service \"{$name}\" is not defined.");
        }
        
        if (!array_get($config, 'service')) {
            throw new InvalidArgumentException("Invalid service provided for Google service \"{$name}\"");
        }
        
        $client = new \Google_Client((array) array_get($config, 'extra'));
        
        if (array_get($config, 'auth')) {
            $client->setAuthConfig($config['auth']);
        }
        
        foreach ((array) array_get($config, 'scopes') as $scope) {
            if (!$scope) {
                throw new InvalidArgumentException("Invalid scope provided for Google service \"{$name}\"");
            } else {
                $client->addScope($scope);
            }
        }
        
        $service = $this->app->make($config['service'], ['client' => $client]);
        
        return $service;
    }

    /**
     * Get the google service configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig($name)
    {
        return array_get($this->app['google.config'], "services.{$name}");
    }

    /**
     * Get the default google service name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['google.config']['default'];
    }

    /**
     * Dynamically call the default service instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->service()->$method(...$parameters);
    }
}
