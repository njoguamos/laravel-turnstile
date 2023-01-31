<?php

use NjoguAmos\Turnstile\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Illuminate\Http\Request;

uses(TestCase::class)->in(__DIR__);

function createRequest(string $uri, string $method, array $data = []): Request
{
    $symfonyRequest = SymfonyRequest::create(uri: $uri, method: $method);

    return Request::createFromBase($symfonyRequest)->merge($data);
}

function setSecretKey(string $type): void
{
    $key = match ($type) {
        'valid'   => '1x0000000000000000000000000000000AA',
        'invalid' => '2x0000000000000000000000000000000AA',
        'spent'   => '3x0000000000000000000000000000000AA',
    };

    config()->set(key: 'turnstile.secretkey', value: $key);
}
