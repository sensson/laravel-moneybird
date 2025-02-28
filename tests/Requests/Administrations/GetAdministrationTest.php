<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Administration;
use Sensson\Moneybird\Requests\Administrations\GetAdministration;

test('get administration request has correct endpoint', function () {
    expect((new GetAdministration('123456'))->resolveEndpoint())->toBe('administrations/123456.json');
});

test('get administration request uses GET method', function () {
    expect((new GetAdministration('123456'))->getMethod())->toBe(Method::GET);
});

test('get administration request returns administration dto', function () {
    $administrationId = '123456';
    $mockData = [
        'id' => $administrationId,
        'name' => 'My Administration',
        'language' => 'en',
        'currency' => 'EUR',
        'country' => 'NL',
        'time_zone' => 'Europe/Amsterdam',
        'access' => true,
    ];

    // Create a mock client that will intercept requests
    $mockClient = new MockClient([
        GetAdministration::class => MockResponse::make($mockData, 200),
    ]);

    // Create a connector with the mock client
    $connector = new MoneybirdConnector;
    $connector->withMockClient($mockClient);

    // Make the request
    $request = new GetAdministration($administrationId);
    $response = $connector->send($request);

    // Check that we sent the intended request
    $mockClient->assertSent(GetAdministration::class);

    // Verify the response data
    $administration = $request->createDtoFromResponse($response);
    expect($administration)->toBeInstanceOf(Administration::class)
        ->and($administration->id)->toBe($administrationId)
        ->and($administration->name)->toBe('My Administration')
        ->and($administration->language)->toBe('en')
        ->and($administration->currency)->toBe('EUR')
        ->and($administration->country)->toBe('NL')
        ->and($administration->time_zone)->toBe('Europe/Amsterdam')
        ->and($administration->access)->toBeTrue();
});
