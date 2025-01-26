<?php

return [

    'baseUri' => env('MOMO_URL'),
    'currency' => env('MOMO_CURRENCY', 'EUR'),
    'environment' => env('MOMO_ENVIRONMENT', 'sandbox'),


    'products' => [
        'collection' => [
            'subscription_key' => env('MOMO_COLLECTION_SUBSCRIPTION_KEY'),
            'client_id' => env('MOMO_COLLECTION_CLIENT_ID'),
            'client_secret' => env('MOMO_COLLECTION_SECRET'),
        ]
    ]

];
