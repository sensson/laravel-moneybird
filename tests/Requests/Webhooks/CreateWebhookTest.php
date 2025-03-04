<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Webhook;
use Sensson\Moneybird\Enums\WebhookEvent;
use Sensson\Moneybird\Requests\Webhooks\CreateWebhook;

test('create webhook request has correct endpoint', function () {
    $webhook = Webhook::from([
        'url' => 'https://example.com/webhook',
        'enabled_events' => [WebhookEvent::ContactActivated, WebhookEvent::SalesInvoiceCreated],
    ]);

    expect((new CreateWebhook($webhook))->resolveEndpoint())->toBe('webhooks.json');
});

test('create webhook request uses POST method', function () {
    $webhook = Webhook::from([
        'url' => 'https://example.com/webhook',
        'enabled_events' => [WebhookEvent::ContactActivated, WebhookEvent::SalesInvoiceCreated],
    ]);

    expect((new CreateWebhook($webhook))->getMethod())->toBe(Method::POST);
});

test('create webhook request sends correct payload', function () {
    $webhook = Webhook::from([
        'url' => 'https://example.com/webhook',
        'enabled_events' => [WebhookEvent::ContactActivated, WebhookEvent::SalesInvoiceCreated],
    ]);

    $request = new CreateWebhook($webhook);

    expect($request->body()->all())->toBe([
        'webhook' => [
            'url' => 'https://example.com/webhook',
            'enabled_events' => [WebhookEvent::ContactActivated, WebhookEvent::SalesInvoiceCreated],
        ],
    ]);
});

test('create webhook request returns webhook data', function () {
    $webhook = Webhook::from([
        'url' => 'https://example.com/webhook',
        'enabled_events' => [WebhookEvent::ContactActivated, WebhookEvent::SalesInvoiceCreated],
    ]);

    $mockData = [
        'id' => '1',
        'administration_id' => '123456',
        'url' => 'https://example.com/webhook',
        'enabled_events' => [WebhookEvent::ContactActivated, WebhookEvent::SalesInvoiceCreated],
        'last_http_status' => null,
        'last_http_body' => null,
        'last_http_response_at' => null,
        'created_at' => '2023-01-01T00:00:00.000Z',
        'updated_at' => '2023-01-01T00:00:00.000Z',
    ];

    $mockClient = new MockClient([
        CreateWebhook::class => MockResponse::make($mockData, 201),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new CreateWebhook($webhook));
    $mockClient->assertSent(CreateWebhook::class);

    $result = $response->dto();

    expect($result)->toBeInstanceOf(Webhook::class)
        ->and($result->id)->toBe('1')
        ->and($result->url)->toBe('https://example.com/webhook')
        ->and($result->enabled_events)->toContain(WebhookEvent::ContactActivated)
        ->and($result->administration_id)->toBe('123456');
});
