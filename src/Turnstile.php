<?php

namespace NjoguAmos\Turnstile;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class Turnstile
{
    protected string $url;

    protected string $secretkey;

    public function __construct()
    {
        $this->url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

        $this->secretkey = config(key: 'turnstile.secretkey');

        if (empty($this->secretkey)) {
            throw new RuntimeException(message:  trans(key: 'turnstile::turnstile.no_secret_key'));
        }
    }

    public function validate(string $response): bool
    {
        $response = Http::acceptJson()
            ->post($this->url, [
            'response' => $response,
            'secret'   => $this->secretkey
        ]);

        return (bool) $response->json()['success'];
    }
}
