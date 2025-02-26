<?php

namespace Sensson\Moneybird;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Sensson\Moneybird\Commands\MoneybirdCommand;

class MoneybirdServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-moneybird')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_moneybird_table')
            ->hasCommand(MoneybirdCommand::class);
    }
}
