<?php

declare(strict_types=1);

namespace NjoguAmos\Turnstile\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use NjoguAmos\Turnstile\Turnstile;

class TurnstileRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! (new Turnstile())->validate(token: $value)) {
            $fail(trans(key: 'turnstile::turnstile.failed'));
        }
    }
}
