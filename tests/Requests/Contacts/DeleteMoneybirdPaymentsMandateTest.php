<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\Contacts\DeleteMoneybirdPaymentsMandate;

test('delete moneybird payments mandate request has correct endpoint', function () {
    expect((new DeleteMoneybirdPaymentsMandate('123456'))->resolveEndpoint())
        ->toBe('contacts/123456/moneybird_payments_mandate.json');
});

test('delete moneybird payments mandate request uses delete method', function () {
    expect((new DeleteMoneybirdPaymentsMandate('123456'))->getMethod())->toBe(Method::DELETE);
});

test('delete moneybird payments mandate request accepts an empty response', function () {
    $mockClient = new MockClient([
        DeleteMoneybirdPaymentsMandate::class => MockResponse::make(status: 204),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new DeleteMoneybirdPaymentsMandate('123456'));

    expect($response->status())->toBe(204);
});
