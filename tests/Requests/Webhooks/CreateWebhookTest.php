<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Webhook;
use Sensson\Moneybird\Enums\WebhookEvent;
use Sensson\Moneybird\Enums\WebhookEventGroup;
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
        'enabled_events' => [WebhookEventGroup::Contact, WebhookEvent::ContactCreated],
    ]);

    $mockClient = new MockClient([
        CreateWebhook::class => MockResponse::make([], 201),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $request = new CreateWebhook($webhook);
    $connector->send($request);

    $body = $mockClient->getLastPendingRequest()?->body()?->all();

    expect($body)
        ->toHaveKey('url', 'https://example.com/webhook')
        ->toHaveKey('enabled_events', [WebhookEventGroup::Contact, WebhookEvent::ContactCreated])
        ->not->toHaveKey('webhook')
        ->and(json_decode(
            json_encode($body, JSON_THROW_ON_ERROR),
            true,
            flags: JSON_THROW_ON_ERROR,
        ))->toHaveKey('enabled_events', ['contact', 'contact_created']);
});

test('create webhook request returns webhook data', function () {
    $webhook = Webhook::from([
        'url' => 'https://example.com/webhook',
        'enabled_events' => [WebhookEventGroup::Contact, WebhookEvent::SalesInvoiceCreated],
    ]);

    $mockData = [
        'id' => '1',
        'administration_id' => '123456',
        'url' => 'https://example.com/webhook',
        'enabled_events' => ['contact', 'sales_invoice_created'],
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
        ->and($result->administration_id)->toBe('123456');

    expect($result->enabled_events)
        ->toBe([WebhookEventGroup::Contact, WebhookEvent::SalesInvoiceCreated]);
});
