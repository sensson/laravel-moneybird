<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\MoneybirdPaymentsMandateUrl;
use Sensson\Moneybird\Requests\Contacts\CreateMoneybirdPaymentsMandateUrl;

test('create moneybird payments mandate url request has correct endpoint', function () {
    expect((new CreateMoneybirdPaymentsMandateUrl('123456'))->resolveEndpoint())
        ->toBe('contacts/123456/moneybird_payments_mandate/url.json');
});

test('create moneybird payments mandate url request uses post method', function () {
    expect((new CreateMoneybirdPaymentsMandateUrl('123456'))->getMethod())->toBe(Method::POST);
});

test('create moneybird payments mandate url request returns a mandate url', function () {
    $mockClient = new MockClient([
        CreateMoneybirdPaymentsMandateUrl::class => MockResponse::make([
            'url' => 'https://moneybird.com/mandate/setup/abc123',
            'expires_at' => '2026-08-25T12:00:00Z',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $result = $connector->send(new CreateMoneybirdPaymentsMandateUrl('123456'))->dto();

    expect($result)->toBeInstanceOf(MoneybirdPaymentsMandateUrl::class)
        ->and($result->url)->toBe('https://moneybird.com/mandate/setup/abc123')
        ->and($result->expires_at)->toBe('2026-08-25T12:00:00Z');
});
