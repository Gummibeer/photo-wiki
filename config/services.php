<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'google_maps' => [
        'key' => env('GOOGLE_MAPS_KEY'),
    ],

    'google_analytics' => [
        'code' => env('GOOGLE_ANALYTICS_CODE'),
    ],

    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID'),
    ],

];
