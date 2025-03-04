<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Webhook;
use Sensson\Moneybird\Enums\WebhookEvent;
use Sensson\Moneybird\Requests\Webhooks\CreateWebhook;
use Sensson\Moneybird\Requests\Webhooks\DeleteWebhook;
use Sensson\Moneybird\Requests\Webhooks\ListWebhooks;
use Sensson\Moneybird\Resources\WebhookResource;

test('webhook resource all() method sends correct request', function () {
    $mockWebhooks = [
        [
            'id' => '1',
            'administration_id' => '123456',
            'url' => 'https://example.com/webhook1',
            'enabled_events' => [WebhookEvent::ContactCreated, WebhookEvent::SalesInvoiceCreated],
            'created_at' => '2023-01-01T00:00:00.000Z',
            'updated_at' => '2023-01-01T00:00:00.000Z',
        ],
        [
            'id' => '2',
            'administration_id' => '123456',
            'url' => 'https://example.com/webhook2',
            'enabled_events' => [WebhookEvent::ContactCreated, WebhookEvent::SalesInvoiceCreated],
            'created_at' => '2023-01-02T00:00:00.000Z',
            'updated_at' => '2023-01-02T00:00:00.000Z',
        ],
    ];

    $mockClient = new MockClient([
        ListWebhooks::class => MockResponse::make($mockWebhooks, 200),
    ]);

    $connector = (new MoneybirdConnector)
        ->withMockClient($mockClient);

    $resource = new WebhookResource($connector);
    $result = $resource->all();

    $mockClient->assertSent(ListWebhooks::class);

    expect($result)->toHaveCount(2)
        ->and($result->first())->toBeInstanceOf(Webhook::class)
        ->and($result->first()->id)->toBe('1');
});

test('webhook resource create() method sends correct request', function () {
    $webhook = Webhook::from([
        'url' => 'https://example.com/webhook',
        'enabled_events' => [WebhookEvent::ContactActivated, WebhookEvent::SalesInvoiceCreated],
    ]);

    $mockWebhookResponse = [
        'id' => '1',
        'administration_id' => '123456',
        'url' => 'https://example.com/webhook',
        'enabled_events' => [WebhookEvent::ContactActivated, WebhookEvent::SalesInvoiceCreated],
        'created_at' => '2023-01-01T00:00:00.000Z',
        'updated_at' => '2023-01-01T00:00:00.000Z',
    ];

    $mockClient = new MockClient([
        CreateWebhook::class => MockResponse::make($mockWebhookResponse, 201),
    ]);

    $connector = (new MoneybirdConnector)
        ->withMockClient($mockClient);

    $resource = new WebhookResource($connector);
    $result = $resource->create($webhook);

    $mockClient->assertSent(CreateWebhook::class);

    expect($result)->toBeInstanceOf(Webhook::class)
        ->and($result->id)->toBe('1')
        ->and($result->url)->toBe('https://example.com/webhook')
        ->and(count($result->enabled_events))->toBe(2);
});

test('webhook resource delete() method sends correct request', function () {
    $mockClient = new MockClient([
        DeleteWebhook::class => MockResponse::make([], 204),
    ]);

    $connector = (new MoneybirdConnector)
        ->withMockClient($mockClient);

    $resource = new WebhookResource($connector);
    $resource->delete('123');

    $mockClient->assertSent(DeleteWebhook::class);
});
