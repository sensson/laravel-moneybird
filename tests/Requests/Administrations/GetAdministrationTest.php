<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Administration;
use Sensson\Moneybird\Requests\Administrations\GetAdministration;

test('get administration request has correct endpoint', function () {
    $administrationId = '123456';
    $endpoint = (new GetAdministration($administrationId))->resolveEndpoint();

    expect($endpoint)->toBe('administrations/123456.json');
});

test('get administration request uses GET method', function () {
    $method = (new GetAdministration('123456'))->getMethod();

    expect($method)->toBe(Method::GET);
});

it('gets an administration', function () {
    $mockData = [
        'id' => '12345',
        'name' => 'My Administration',
        'language' => 'en',
        'currency' => 'EUR',
        'country' => 'NL',
        'time_zone' => 'Europe/Amsterdam',
        'access' => true,
    ];

    $mockClient = new MockClient([
        GetAdministration::class => MockResponse::make($mockData),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new GetAdministration('12345'));
    $mockClient->assertSent(GetAdministration::class);

    $administration = $response->dto();

    expect($administration)->toBeInstanceOf(Administration::class)
        ->and($administration->id)->toBe('12345')
        ->and($administration->name)->toBe('My Administration')
        ->and($administration->language)->toBe('en')
        ->and($administration->currency)->toBe('EUR')
        ->and($administration->country)->toBe('NL')
        ->and($administration->time_zone)->toBe('Europe/Amsterdam')
        ->and($administration->access)->toBeTrue();
});
