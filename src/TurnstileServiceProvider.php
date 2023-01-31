<?php

namespace NjoguAmos\Turnstile;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
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
            ->name(name: 'turnstile')
            ->hasTranslations()
            ->hasConfigFile(configFileName: 'turnstile')
            ->hasInstallCommand(callable: function (InstallCommand $command) {
                $command
                    ->startWith(callable: function (InstallCommand $command) {
                        $command->info(string: 'Welcome! We are going to publish service provider and config files.');
                    })
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub(vendorSlashRepoName: 'njoguamos/laravel-turnstile')
                    ->endWith(callable: function (InstallCommand $command) {
                        $command->info(string: 'Congratulation! You add your turnstile key and you are ready to go. Happy coding!');
                    });
            });
    }

    public function register()
    {
        parent::register();

        $this->app->bind(abstract: Turnstile::class, concrete: function ($app) {
            return new Turnstile(
                url: 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                secretKey: config(key: 'turnstile.secretkey')
            );
        });
    }
}
