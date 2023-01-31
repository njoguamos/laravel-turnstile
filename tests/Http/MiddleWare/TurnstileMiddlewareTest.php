<?php

use Illuminate\Support\Str;
use NjoguAmos\Turnstile\Http\Middleware\TurnstileMiddleware;
use Symfony\Component\HttpFoundation\Response;

test(description: 'it skips the middleware when disabled', closure: function () {
    config()->set(key: 'turnstile.enabled', value: false);

    $response = (new TurnstileMiddleware())
        ->handle(
            request: createRequest(uri: '/sign-up-fo', method: 'post'),
            next: fn () => new Response()
        );

    expect(value: $response->isRedirect())->toBeFalse();
});

test(description: 'it redirects back the request if the token is invalid', closure: function () {
    setSecretKey(type: 'invalid');

    $response = (new TurnstileMiddleware())
        ->handle(
            request: createRequest(
                uri: '/register',
                method: 'post',
                data: [config(key: 'turnstile.field') => Str::random(length: 40)]
            ),
            next: fn () => new Response()
        );

    expect(value: $response->isRedirect())->toBeTrue()
        ->and(value: $response->getSession()->get(key:'status'))
        ->toBe(expected: trans(key: 'turnstile::turnstile.failed'));
});

test(description: 'it redirects back the request if the token is already spent', closure: function () {
    setSecretKey(type: 'spent');

    $response = (new TurnstileMiddleware())
        ->handle(
            request: createRequest(
                uri: '/order/create',
                method: 'post',
                data: [config(key: 'turnstile.field') => Str::random(length: 100)]
            ),
            next: fn () => new Response()
        );

    expect(value: $response->isRedirect())->toBeTrue()
        ->and(value: $response->getSession()->get(key:'status'))
        ->toBe(expected: trans(key: 'turnstile::turnstile.failed'));
});

test(description: 'it allows the request to pass when the token is valid', closure: function () {
    setSecretKey(type: 'valid');

    $response = (new TurnstileMiddleware())
        ->handle(
            request: createRequest(
                uri: '/',
                method: 'post',
                data: [config(key: 'turnstile.field') => Str::random(length: 100)]
            ),
            next: fn () => new Response()
        );

    expect(value: $response->isRedirect())->toBeFalse()
        ->and(value: session()->get(key:'status'))->toBeEmpty()
        ->and(value: $response->isSuccessful())->toBeTrue();
});
