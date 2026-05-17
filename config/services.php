<?php

return [

    'stripe' => [
        'key'             => env('STRIPE_KEY'),
        'secret'          => env('STRIPE_SECRET'),
        'webhook_secret'  => env('STRIPE_WEBHOOK_SECRET'),
        'success_url'     => env('STRIPE_SUCCESS_URL', '/subscriptions/success'),
        'cancel_url'      => env('STRIPE_CANCEL_URL', '/pricing'),
    ],

    'openai' => [
        'key'   => env('OPENAI_API_KEY'),
        'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
    ],

    'affinda' => [
        'key' => env('AFFINDA_API_KEY'),
        'workspace' => env('AFFINDA_WORKSPACE'),
    ],

];
