<?php

namespace NjoguAmos\Turnstile;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class Turnstile
{
    protected string $url;

    protected ?string $secretKey;

    public function __construct()
    {
        $this->url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

        $this->secretKey = config(key: 'turnstile.secretkey');

        if (empty($this->secretKey)) {
            throw new RuntimeException(message: trans(key: 'turnstile::turnstile.no_secret_key'));
        }
    }

    public function validate(string $token): bool
    {
        $response = Http::acceptJson()
            ->post($this->url, [
                'response' => $token,
                'secret'   => $this->secretKey
            ]);

        return (bool)$response->json()['success'];
    }
}
