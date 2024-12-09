<?php

namespace NjoguAmos\Turnstile;

final class TurnstileResponse
{
    /**
     * @param  array<string|ErrorCodes>|null $error_codes
     */
    public function __construct(
        public bool $success,
        public ?array $error_codes = [],
    ) {
        if ($error_codes !== null) {
            $this->error_codes = collect($error_codes)
                ->map(callback: function ($code) {
                    if (! $code instanceof ErrorCodes) {
                        return ErrorCodes::from($code);
                    }
                })->all();
        }
    }
}
