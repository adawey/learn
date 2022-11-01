<?php
return [

   /*
     |--------------------------------------------------------------------------
     | Merchant profile id
     |--------------------------------------------------------------------------
     |
     | Your merchant profile id , you can find the profile id on your PayTabs Merchant’s Dashboard- profile.
     |
     */

    'profile_id' => env('paytabs_profile_id', 102062),

    /*
   |--------------------------------------------------------------------------
   | Server Key
   |--------------------------------------------------------------------------
   |
   | You can find the Server key on your PayTabs Merchant’s Dashboard - Developers - Key management.
   |
   */

    'server_key' => env('paytabs_server_key'),

    /*
   |--------------------------------------------------------------------------
   | Currency
   |--------------------------------------------------------------------------
   |
   | The currency you registered in with PayTabs account
     you must pass value from this array ['AED','EGP','SAR','OMR','JOD','US']
   |
   */

    'currency' => env('paytabs_currency', 'US'),
    // 'callback' => env('paytabs_ipn_callback', [ App\Http\Controllers\PaytabsController::class,'callback']),

    /*
   |--------------------------------------------------------------------------
   | Region
   |--------------------------------------------------------------------------
   |
   | The region you registered in with PayTabs
     you must pass value from this array ['ARE','EGY','SAU','OMN','JOR','GLOBAL']
   |
   */

    'region' => env('paytabs_region', 'JOR'),

];
