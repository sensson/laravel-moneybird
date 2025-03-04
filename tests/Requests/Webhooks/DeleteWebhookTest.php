<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\Webhooks\DeleteWebhook;

test('delete webhook request has correct endpoint', function () {
    expect((new DeleteWebhook('123'))->resolveEndpoint())->toBe('webhooks/123.json');
});

test('delete webhook request uses DELETE method', function () {
    expect((new DeleteWebhook('123'))->getMethod())->toBe(Method::DELETE);
});

test('delete webhook request sends correct request', function () {
    $mockClient = new MockClient([
        DeleteWebhook::class => MockResponse::make([], 204),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new DeleteWebhook('123'));

    $mockClient->assertSent(DeleteWebhook::class);
    expect($response->status())->toBe(204);
});
