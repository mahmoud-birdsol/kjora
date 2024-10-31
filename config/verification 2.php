<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Verification codes table name
     |--------------------------------------------------------------------------
     |
     | This config variable is for verification codes table name you can change
     | this name at your disclosure as long as the table contains phone and
     | code columns and created at date time for expiry time allowed.
     |
     */
    'verification_codes_table' => 'verification_codes',

    /*
     |--------------------------------------------------------------------------
     | Expiry time of verification codes
     |--------------------------------------------------------------------------
     |
     | This variable will allow you to set a custom expiry time on verification
     | codes sent through the app for security reasons a sensible default
     | is set at 30 min but you can change this at your convenience.
     |
     */
    'expiry' => env('VERIFICATION_EXPIRY', 30),
];
