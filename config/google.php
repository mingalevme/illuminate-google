<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Default Google Service
    |--------------------------------------------------------------------------
    |
    | This option controls the default google service that gets used while
    | using this library. This service is used when another is not explicitly
    | specified.
    |
    */

    'default' => env('GOOGLE_DRIVER', 'default'),
    
    /*
    |--------------------------------------------------------------------------
    | Google Services
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the google "services" for your application as
    | well as their scopes. You may even define multiple services for the
    | same google service if you need it for some reasons.
    |
    */

    'services' => [

        'default' => [
            
            /*
             * Google_Service_*-class is used
             */
            'service' => env('GOOGLE_SERVICE'),
            
            /**
             * This (if defined) is passed to Google_Client::setAuthConfig(),
             * it may be a path to file or an array:
             * 'auth' => ['client_id' => '...', 'client_email' => ...],
             * For more details
             * @see Google_Client::setAuthConfig
             */
            'auth' => env('GOOGLE_KEY_PATH', resource_path('google-service-account-key.json')),
            
            /**
             * Scopes to set to Google_Client
             */
            'scopes' => [
                env('GOOGLE_SCOPE', 'https://www.googleapis.com/auth/analytics'),
            ],
            
            /**
             * This array (if defined) is passed to Google_Client constructor
             */
            'extra' => [
                //'application_name' => 'EXAMPLE_APP_NAME',
                // '...' => '...',
            ],
            
        ],
        
        'analytics' => [
            'service' => env('GOOGLE_SERVICE', 'Google_Service_Analytics'),'auth' => env('GOOGLE_KEY_PATH', resource_path('google-service-account-key.json')),
            'scopes' => [
                env('GOOGLE_SCOPE', 'https://www.googleapis.com/auth/analytics'),
            ],
        ],
        
        'drive' => [
            'service' => env('GOOGLE_SERVICE', 'Google_Service_Drive'),
            'auth' => env('GOOGLE_KEY_PATH', resource_path('google-service-account-key.json')),
            'scopes' => [
                env('GOOGLE_SCOPE', 'https://www.googleapis.com/auth/drive'),
            ],
        ],
        
        'android-publisher' => [
            'service' => env('GOOGLE_SERVICE', 'Google_Service_AndroidPublisher'),
            'auth' => env('GOOGLE_KEY_PATH', resource_path('google-service-account-key.json')),
            'scopes' => [
                env('GOOGLE_SCOPE', 'https://www.googleapis.com/auth/androidpublisher'),
            ],
        ],

    ],
];
