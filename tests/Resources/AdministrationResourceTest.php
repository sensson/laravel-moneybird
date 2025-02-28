<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\Administrations\GetAdministration;
use Sensson\Moneybird\Requests\Administrations\ListAdministrations;
use Sensson\Moneybird\Resources\AdministrationResource;

test('administrator resource is instantiated correctly', function () {
    $connector = new MoneybirdConnector;
    $resource = $connector->administrations();

    expect($resource)->toBeInstanceOf(AdministrationResource::class);
});

test('all() calls the list administrations request', function () {
    $mockClient = new MockClient([
        ListAdministrations::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new AdministrationResource($connector))->all();

    $mockClient->assertSent(ListAdministrations::class);
});

test('get() calls the get administration request', function () {
    $mockClient = new MockClient([
        GetAdministration::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new AdministrationResource($connector))->get('1234');

    $mockClient->assertSent(GetAdministration::class);
});
