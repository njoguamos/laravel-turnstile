<?php

namespace NjoguAmos\Turnstile\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NjoguAmos\Turnstile\Turnstile
 */
class Turnstile extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \NjoguAmos\Turnstile\Turnstile::class;
    }
}
