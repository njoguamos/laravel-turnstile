<?php

use Illuminate\Support\Str;
use NjoguAmos\Turnstile\ErrorCodes;
use NjoguAmos\Turnstile\Turnstile;
use NjoguAmos\Turnstile\TurnstileResponse;

describe(description: 'class', tests: function () {

    it(description: 'throw an exception when secret key is not available', closure: function () {
        config()->set(key: 'turnstile.secretkey', value: '');

        new Turnstile();
    })->throws(exception: RuntimeException::class);

});

describe(description: 'validate', tests: function () {

    it(description: 'return true when valid token is provided', closure: function () {
        setSecretKey(type: 'valid');

        expect(value: (new Turnstile())->validate(token: Str::random(length: 100)))->toBeTrue();
    });

    it(description: 'return false when invalid token is provided', closure: function () {
        setSecretKey(type: 'invalid');

        expect(value: (new Turnstile())->validate(token: Str::random(length: 100)))->toBeFalse();
    });

    it(description: 'return false when used token is provided', closure: function () {
        setSecretKey(type: 'spent');

        expect(value: (new Turnstile())->validate(token: Str::random(length: 100)))->toBeFalse();
    });

});

describe(description: 'response', tests: function () {

    it(description: 'return correct turnstile response for valid token', closure: function () {
        setSecretKey(type: 'valid');

        $response = (new Turnstile())->getResponse(token: Str::random(length: 100));

        expect(value: $response)->toBeInstanceOf(class: TurnstileResponse::class)
            ->success->toBeTrue()
            ->error_codes->toBeEmpty();
    });

    it(description: 'return correct turnstile response for invalid token', closure: function () {
        setSecretKey(type: 'spent');

        $response = (new Turnstile())->getResponse(token: Str::random(length: 100));

        expect(value: $response)->toBeInstanceOf(class: TurnstileResponse::class)
            ->success->toBefalse()
            ->error_codes->toContain(ErrorCodes::TIMEOUT_OR_DUPLICATE);
    });
});
