<?php

use Saloon\Exceptions\Request\Statuses\UnauthorizedException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Exceptions\AccessTokenRevokedException;
use Sensson\Moneybird\Requests\Administrations\ListAdministrations;

test('connector has correct base url', function () {
    $connector = new MoneybirdConnector;

    expect($connector->resolveBaseUrl())->toBe('https://moneybird.com/api/v2');
});

test('connector base url includes administration id when set', function () {
    $administrationId = '123456';
    $connector = new MoneybirdConnector;
    $connector->administration($administrationId);

    expect($connector->resolveBaseUrl())->toBe("https://moneybird.com/api/v2/{$administrationId}");
});

test('connector for administration method returns self for chaining', function () {
    $connector = new MoneybirdConnector;

    expect($connector->administration('123456'))->toBe($connector);
});

test('connector accepts json by default', function () {
    $connector = new MoneybirdConnector;

    // Check if the connector uses the AcceptsJson trait
    $traits = class_uses_recursive(get_class($connector));
    expect($traits)->toContain(\Saloon\Traits\Plugins\AcceptsJson::class);
});

it('throws AccessTokenRevokedException when access token is revoked', function () {
    $mockClient = new MockClient([
        ListAdministrations::class => MockResponse::make('access token revoked', 401),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $connector->send(new ListAdministrations);
})->throws(AccessTokenRevokedException::class);

it('does not throw AccessTokenRevokedException for other 401 responses', function () {
    $mockClient = new MockClient([
        ListAdministrations::class => MockResponse::make('unauthorized', 401),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $connector->send(new ListAdministrations);
})->throws(UnauthorizedException::class);
