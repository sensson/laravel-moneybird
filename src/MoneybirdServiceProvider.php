<?php

namespace Sensson\Moneybird;

use Sensson\Moneybird\Commands\MoneybirdCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MoneybirdServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-moneybird')
            ->hasConfigFile();
    }
}
