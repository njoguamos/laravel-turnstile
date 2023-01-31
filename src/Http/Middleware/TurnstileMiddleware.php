<?php

namespace NjoguAmos\Turnstile\Http\Middleware;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use NjoguAmos\Turnstile\Turnstile;

class TurnstileMiddleware
{
    /**  @throws BindingResolutionException */
    public function handle(Request $request, Closure $next)
    {
        if (!config(key: 'turnstile.enabled')) {
            return $next($request);
        }

        if ($this->validateTurnstile(token: config(key: 'turnstile.field'))) {
            return $next($request);
        }

        return redirect()
            ->back()
            ->with(
                key: 'status',
                value: trans(key: 'turnstile::turnstile.failed')
            );
    }

    /**  @throws BindingResolutionException */
    protected function validateTurnstile(string $token): bool
    {
        return app()->make(abstract: Turnstile::class)->validate($token);
    }
}
