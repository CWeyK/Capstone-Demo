<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'gst' => [
        'client_id'     => env('GST_CLIENT_ID'),
        'client_secret' => env('GST_CLIENT_SECRET'),
        'base_url'      => env('GST_BASE_URI'),
    ],

    'ninja_van' => [
        'client_id'     => (env('APP_ENV') == 'production') ? env('NINJA_VAN_CLIENT_ID') : env('SANDBOX_NINJA_VAN_CLIENT_ID'),
        'client_secret' => (env('APP_ENV') == 'production') ? env('NINJA_VAN_CLIENT_SECRET') : env('SANDBOX_NINJA_VAN_CLIENT_SECRET'),
        'base_url'      => (env('APP_ENV') == 'production') ? env('NINJA_VAN_BASE_URI') : env('SANDBOX_NINJA_VAN_BASE_URI'),
    ],

    'dhl' => [
        'client_id' => (env('APP_ENV') == 'production') ? env('DHL_CLIENT_ID') : env('SANDBOX_DHL_CLIENT_ID'),
        'password'  => (env('APP_ENV') == 'production') ? env('DHL_PASSWORD') : env('SANDBOX_DHL_PASSWORD'),
        'pickup_id' => (env('APP_ENV') == 'production') ? env('DHL_PICKUP_ACCOUNT_ID') : env('SANDBOX_DHL_PICKUP_ACCOUNT_ID'),
        'soldto_id' => (env('APP_ENV') == 'production') ? env('DHL_SOLDTO_ACCOUNT_ID') : env('SANDBOX_DHL_SOLDTO_ACCOUNT_ID'),
        'base_url'  => (env('APP_ENV') == 'production') ? env('DHL_BASE_URI') : env('SANDBOX_DHL_BASE_URI'),
    ],

    'senangpay' => [
        'id'                => (env('APP_ENV') == 'production') ? env('SENANGPAY_MERCHANT_ID') : env('SANDBOX_SENANGPAY_MERCHANT_ID'),
        'secret'            => (env('APP_ENV') == 'production') ? env('SENANGPAY_SECRET_KEY') : env('SANDBOX_SENANGPAY_SECRET_KEY'),
        'base_url'          => (env('APP_ENV') == 'production') ? env('SENANGPAY_BASE_URL') : env('SANDBOX_SENANGPAY_BASE_URL'),
        'username'          => (env('APP_ENV') == 'production') ? env('SENANGPAY_USERNAME') : env('DIRECT_API_USERNAME'),
        'direct_base_url'   => (env('APP_ENV') == 'production') ? env('SENANGPAY_DIRECT_BASE_URL') : env('DIRECT_API_BASE_URL'),
    ],
];
