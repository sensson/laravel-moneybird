<?php

use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Administration;
use Sensson\Moneybird\Requests\Administrations\GetAdministration;
use Sensson\Moneybird\Requests\Administrations\ListAdministrations;
use Sensson\Moneybird\Resources\AdministrationResource;

test('administrator resource is instantiated correctly', function () {
    $connector = new MoneybirdConnector;
    $resource = $connector->administrations();

    expect($resource)->toBeInstanceOf(AdministrationResource::class);
});

test('administrator resource all method sends list administrations request', function () {
    $mockData = [
        ['id' => '1', 'name' => 'Administration 1'],
        ['id' => '2', 'name' => 'Administration 2'],
    ];

    // Create a mock client that will intercept requests
    $mockClient = new MockClient([
        ListAdministrations::class => MockResponse::make($mockData, 200),
    ]);

    // Create a connector with the mock client
    $connector = new MoneybirdConnector;
    $connector->withMockClient($mockClient);

    // Execute the request through the resource
    $response = $connector->administrations()->all();

    // Verify request was sent correctly
    $mockClient->assertSent(ListAdministrations::class);

    // Verify response is a collection of Administration objects
    expect($response)->toBeInstanceOf(Collection::class)
        ->and($response)->toHaveCount(2)
        ->and($response[0])->toBeInstanceOf(Administration::class)
        ->and($response[0]->id)->toBe('1')
        ->and($response[1]->id)->toBe('2');
});

test('administrator resource get method sends get administration request with correct id', function () {
    $administrationId = '12345';
    $mockData = [
        'id' => $administrationId,
        'name' => 'Test Administration',
    ];

    // Create a mock client that will intercept requests
    $mockClient = new MockClient([
        GetAdministration::class => MockResponse::make($mockData, 200),
    ]);

    // Create a connector with the mock client
    $connector = new MoneybirdConnector;
    $connector->withMockClient($mockClient);

    // Execute the request through the resource
    $response = $connector->administrations()->get($administrationId);

    // Verify request was sent correctly
    $mockClient->assertSent(GetAdministration::class);

    // Verify response is an Administration object with correct data
    expect($response)->toBeInstanceOf(Administration::class)
        ->and($response->id)->toBe($administrationId)
        ->and($response->name)->toBe('Test Administration');
});
