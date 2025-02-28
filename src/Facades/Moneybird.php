<?php

namespace Sensson\Moneybird\Facades;

use Illuminate\Support\Facades\Facade;
use Sensson\Moneybird\Connectors\AuthConnector;
use Sensson\Moneybird\Connectors\MoneybirdConnector;

/**
 * @see MoneybirdConnector
 */
class Moneybird extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MoneybirdConnector::class;
    }

    public static function auth(): AuthConnector
    {
        return new AuthConnector;
    }
}
