<?php

namespace NjoguAmos\Turnstile\Http\Middleware;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use NjoguAmos\Turnstile\Turnstile;
use Symfony\Component\HttpFoundation\Response;

class TurnstileMiddleware
{
    /**  @throws BindingResolutionException */
    public function handle(Request $request, Closure $next): Response | RedirectResponse
    {
        if (!config(key: 'turnstile.enabled')) {
            return $next($request);
        }

        $token = $request->get(config(key: 'turnstile.field'));

        if ($token && $this->validateTurnstile(token: $token)) {
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
        return (new Turnstile())->validate($token);
    }
}
