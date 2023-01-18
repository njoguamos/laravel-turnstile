<?php

namespace NjoguAmos\Turnstile\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use NjoguAmos\Turnstile\TurnstileServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            TurnstileServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('turnstile.sitekey', '1x00000000000000000000AA');
        config()->set('turnstile.secretkey', '1x0000000000000000000000000000000AA');
    }
}
