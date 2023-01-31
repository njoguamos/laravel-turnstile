<?php

use Illuminate\Support\Str;
use NjoguAmos\Turnstile\Turnstile;

it(description: 'throw an exception when secret key is not available', closure: function () {
    config()->set(key: 'turnstile.secretkey', value: '');

    $this->app->make(abstract: Turnstile::class);
})->throws(exception: RuntimeException::class);

it(description: 'it return correct response based on provided key', closure: function (string $token, bool $expected) {
    config()->set(key: 'turnstile.secretkey', value: $token);

    $turnstile = $this->app->make(abstract: Turnstile::class);

    expect(value: $turnstile->validate(Str::random(length: 100)))
        ->toBe($expected);
})->with('tokens-dataset');
