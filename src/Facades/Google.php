<?php

namespace Mingalevme\Illuminate\Google\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see GoogleManager
 */
class Google extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'google';
    }
}
