<?php

namespace NjoguAmos\Turnstile;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class Turnstile
{
    public function __construct(protected string $url, protected ?string $secretKey)
    {
        if (empty($this->secretKey)) {
            throw new RuntimeException(message:  trans(key: 'turnstile::turnstile.no_secret_key'));
        }
    }

    public function validate(string $token): bool
    {
        $response = Http::acceptJson()
            ->post($this->url, [
            'response' => $token,
            'secret'   => $this->secretKey
        ]);

        return (bool) $response->json()['success'];
    }
}
