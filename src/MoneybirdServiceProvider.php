<?php

namespace Sensson\Moneybird;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MoneybirdServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-moneybird')
            ->hasConfigFile();

        config()->set('data.features.cast_and_transform_iterables', true);
    }
}
