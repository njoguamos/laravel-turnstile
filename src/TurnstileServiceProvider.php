<?php

namespace NjoguAmos\Turnstile;

use NjoguAmos\Turnstile\Commands\TurnstileCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TurnstileServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-turnstile')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-turnstile_table')
            ->hasCommand(TurnstileCommand::class);
    }
}
