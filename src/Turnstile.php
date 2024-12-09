<?php

namespace NjoguAmos\Turnstile;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class Turnstile
{
    protected string $url;

    protected ?string $secretKey;

    public function __construct()
    {
        $this->url = config(key: 'turnstile.url');

        $this->secretKey = config(key: 'turnstile.secretkey');

        if (empty($this->secretKey)) {
            throw new RuntimeException(message: trans(key: 'turnstile::turnstile.no_secret_key'));
        }
    }

    public function validate(string $token): bool
    {
        return $this->getResponse(token: $token)->success;
    }

    /**
     * @throws ConnectionException
     */
    public function getResponse(string $token): TurnstileResponse
    {
        $response = Http::retry(4, 100)
            ->acceptJson()
            ->asForm()
            ->post(url: $this->url, data: [
                'response' => $token,
                'secret'   => $this->secretKey,
            ]);

        return new TurnstileResponse(
            success: $response->json(key: 'success'),
            error_codes: $response->json(key: 'error-codes'),
        );
    }
}
