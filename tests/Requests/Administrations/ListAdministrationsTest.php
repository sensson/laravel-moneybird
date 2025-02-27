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
    // Create mock data
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

    // Create a mock client that will intercept requests
    $mockClient = new MockClient([
        ListAdministrations::class => MockResponse::make($mockData, 200)
    ]);

    // Create a connector with the mock client
    $connector = new MoneybirdConnector();
    $connector->withMockClient($mockClient);

    // Make the request
    $request = new ListAdministrations();
    $response = $connector->send($request);
    
    // Check that we sent the intended request
    $mockClient->assertSent(ListAdministrations::class);
    
    // Verify the response data
    $collection = collect($request->createDtoFromResponse($response));
    expect($collection)->toHaveCount(2)
        ->and($collection->first())->toBeInstanceOf(Administration::class)
        ->and($collection->first()->id)->toBe('123456')
        ->and($collection->first()->name)->toBe('My Administration')
        ->and($collection->first()->access)->toBeTrue()
        ->and($collection->last()->id)->toBe('789012')
        ->and($collection->last()->name)->toBe('Another Administration')
        ->and($collection->last()->access)->toBeFalse();
});