<?php

use Illuminate\Support\Str;
use NjoguAmos\Turnstile\Turnstile;

it(description: 'throw an exception when secret key is not available', closure: function () {
    config()->set(key: 'turnstile.secretkey', value: '');

    $this->app->make(abstract: Turnstile::class);
})->throws(exception: RuntimeException::class);

it(description: 'it return true when valid token is provided', closure: function () {
    setSecretKey(type: 'valid');

    $turnstile = $this->app->make(abstract: Turnstile::class);

    expect(value: $turnstile->validate(Str::random(length: 100)))->toBeTrue();
});

it(description: 'it return false when invalid token is provided', closure: function () {
    setSecretKey(type: 'invalid');

    $turnstile = $this->app->make(abstract: Turnstile::class);

    expect(value: $turnstile->validate(Str::random(length: 100)))->toBeFalse();
});

it(description: 'it return false when used token is provided', closure: function () {
    setSecretKey(type: 'spent');

    $turnstile = $this->app->make(abstract: Turnstile::class);

    expect(value: $turnstile->validate(Str::random(length: 100)))->toBeFalse();
});
