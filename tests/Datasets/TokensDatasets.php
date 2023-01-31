<?php

/** @see https://developers.cloudflare.com/turnstile/frequently-asked-questions/#are-there-sitekeys-and-secret-keys-that-can-be-used-for-testing */
dataset(name: 'tokens-dataset', dataset:[
    'valid token'         => ['1x0000000000000000000000000000000AA', true],
    'invalid token'       => ['2x0000000000000000000000000000000AA', false],
    'token already spent' => ['3x0000000000000000000000000000000AA', false],
]);
