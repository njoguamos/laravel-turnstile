<?php

use NjoguAmos\Turnstile\Turnstile;

it(description: 'throw an exception when secret key is not available', closure: function () {
    config()->set(key: 'turnstile.secretkey', value: '');

    new Turnstile();
})->throws(exception: RuntimeException::class);
