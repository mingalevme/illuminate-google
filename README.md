# illuminate-google
Provides  Google API Library for PHP wrapper for Laravel/Lumen

# Installation

1. ```composer require mingalevme/illuminate-google```.
2. Register the service provider ```Mingalevme\Illuminate\Google\GoogleServiceProvider```.
3. *(Optionally)* Add alias to your bootstrap file:
```php
'Google' => Mingalevme\Illuminate\Google\Facades\Google::class,
```
4. *(Optionally)* For **Larvel** run
```php
php artisan vendor:publish --provider="Mingalevme\Illuminate\Google\GoogleServiceProvider" --tag="config"
``` 
to publish the config file.
5. *(Optionally)* For **Lumen** copy ```/vendor/mingalevme/illuminate-google/config/google.php``` to ```/config/google.php```.
6. **Instead of 4 and/or 5** if you plan to use just one **Google Analytics** (most common case), place JWT-file to ```/resources/google-service-account-key.json```, if the service is not **Google Analytics**, setup one in your **.env**:
```bash
GOOGLE_SERVICE=Google_Service_AndroidPublisher
GOOGLE_SCOPE=https://www.googleapis.com/auth/androidpublisher
```
7.
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mingalevme\Illuminate\Google\Facades\Google;

class MyController extends Controller
{
    public function __invoke(Request $request)
    {
        /* @var $service \Google_Service_AndroidPublisher */
        $service = Google::service();
        
        /* @var $purchase \Google_Service_AndroidPublisher_SubscriptionPurchase */
        try {
            $purchaseData = (array) $service->purchases_subscriptions
                    ->get($request->input('app_id'), $request->input('product_id'), $request->input('purchase_token'))
                    ->toSimpleObject();
        } catch (\Google_Service_Exception $e) {
            $purchaseData = ['errors' => $e->getErrors()];
        }
        
        return response()->json($purchaseData, isset($e) ? $e->getCode() : 200);
    }
}
```
