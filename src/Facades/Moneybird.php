<?php

namespace Sensson\Moneybird\Facades;

use Illuminate\Support\Facades\Facade;
use Saloon\Http\Connector;
use Saloon\Http\Faking\MockClient;
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

    public static function auth(): AuthConnector|Connector
    {
        return resolve(AuthConnector::class);
    }

    public static function authFake(MockClient $mockClient)
    {
        return app()->instance(AuthConnector::class, (new AuthConnector)->withMockClient($mockClient));
    }

    public static function fake(MockClient $mockClient)
    {
        return static::swap((new MoneybirdConnector)->withMockClient($mockClient));
    }

    public static function make(): MoneybirdConnector
    {
        return static::getFacadeRoot();
    }
}
