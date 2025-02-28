<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Administration;
use Sensson\Moneybird\Requests\Administrations\ListAdministrations;

test('list administrations request has correct endpoint', function () {
    expect((new ListAdministrations)->resolveEndpoint())->toBe('administrations.json');
});

test('list administrations request uses GET method', function () {
    expect((new ListAdministrations)->getMethod())->toBe(Method::GET);
});

test('list administrations request returns data collection of administrations', function () {
    $mockData = [
        [
            'id' => '123456',
            'name' => 'My Administration',
            'language' => 'en',
            'currency' => 'EUR',
            'country' => 'NL',
            'time_zone' => 'Europe/Amsterdam',
            'access' => true,
        ],
        [
            'id' => '789012',
            'name' => 'Another Administration',
            'language' => 'nl',
            'currency' => 'EUR',
            'country' => 'NL',
            'time_zone' => 'Europe/Amsterdam',
            'access' => false,
        ],
    ];

    $mockClient = new MockClient([
        ListAdministrations::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new ListAdministrations);
    $mockClient->assertSent(ListAdministrations::class);

    $collection = collect($response->dto());

    expect($collection)->toHaveCount(2)
        ->and($collection->first())->toBeInstanceOf(Administration::class)
        ->and($collection->first()->id)->toBe('123456')
        ->and($collection->first()->name)->toBe('My Administration')
        ->and($collection->first()->access)->toBeTrue()
        ->and($collection->last()->id)->toBe('789012')
        ->and($collection->last()->name)->toBe('Another Administration')
        ->and($collection->last()->access)->toBeFalse();
});
