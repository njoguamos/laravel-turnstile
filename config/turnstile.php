<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Turnstile keys
     |--------------------------------------------------------------------------
     |
     | To start using the Turnstile widget, you will need to obtain a sitekey
     | and a secret key. The sitekey and secret key are always associated
     | with one widget and cannot be reused for other widgets.
     |
     | https://developers.cloudflare.com/turnstile/get-started/
     |
     */
    'secretkey' => env(key: 'TURNSTILE_SECRET_KEY'),
    'sitekey'   => env(key: 'TURNSTILE_SITE_KEY')
];
