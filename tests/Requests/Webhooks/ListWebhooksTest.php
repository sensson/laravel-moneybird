<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Webhook;
use Sensson\Moneybird\Enums\WebhookEvent;
use Sensson\Moneybird\Requests\Webhooks\ListWebhooks;

test('list webhooks request has correct endpoint', function () {
    expect((new ListWebhooks)->resolveEndpoint())->toBe('webhooks.json');
});

test('list webhooks request uses GET method', function () {
    expect((new ListWebhooks)->getMethod())->toBe(Method::GET);
});

test('list webhooks request returns data collection of webhooks', function () {
    $mockData = [
        [
            'id' => '1',
            'administration_id' => '123456',
            'url' => 'https://example.com/webhook1',
            'enabled_events' => [WebhookEvent::ContactActivated, WebhookEvent::SalesInvoiceCreated],
            'created_at' => '2023-01-01T00:00:00.000Z',
            'updated_at' => '2023-01-01T00:00:00.000Z',
        ],
        [
            'id' => '2',
            'administration_id' => '123456',
            'url' => 'https://example.com/webhook2',
            'enabled_events' => [WebhookEvent::ContactActivated, WebhookEvent::SalesInvoiceCreated],
            'created_at' => '2023-01-02T00:00:00.000Z',
            'updated_at' => '2023-01-02T00:00:00.000Z',
        ],
    ];

    $mockClient = new MockClient([
        ListWebhooks::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new ListWebhooks);
    $mockClient->assertSent(ListWebhooks::class);

    $collection = collect($response->dto());

    expect($collection)->toHaveCount(2)
        ->and($collection->first())->toBeInstanceOf(Webhook::class)
        ->and($collection->first()->id)->toBe('1')
        ->and($collection->first()->url)->toBe('https://example.com/webhook1')
        ->and($collection->first()->enabled_events)->toContain(WebhookEvent::ContactCreated)
        ->and($collection->last()->id)->toBe('2')
        ->and($collection->last()->url)->toBe('https://example.com/webhook2')
        ->and(count($collection->last()->enabled_events))->toBe(2);
});
