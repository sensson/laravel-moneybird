<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\SalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\ListSalesInvoices;

test('list sales invoices request has correct endpoint', function () {
    expect((new ListSalesInvoices)->resolveEndpoint())->toBe('sales_invoices.json');
});

test('list sales invoices request uses GET method', function () {
    expect((new ListSalesInvoices)->getMethod())->toBe(Method::GET);
});

test('list sales invoices request returns data collection of sales invoices', function () {
    $mockData = [
        [
            'id' => '123456',
            'administration_id' => '654321',
            'contact_id' => '789012',
            'invoice_id' => 'INV-2023-001',
            'state' => 'open',
            'invoice_date' => '2023-01-01',
            'due_date' => '2023-01-31',
            'reference' => 'Your reference',
            'created_at' => '2023-01-01T12:00:00.000Z',
            'updated_at' => '2023-01-01T12:00:00.000Z',
        ],
        [
            'id' => '789012',
            'administration_id' => '654321',
            'contact_id' => '345678',
            'invoice_id' => 'INV-2023-002',
            'state' => 'paid',
            'invoice_date' => '2023-01-02',
            'due_date' => '2023-02-01',
            'reference' => 'Another reference',
            'created_at' => '2023-01-02T12:00:00.000Z',
            'updated_at' => '2023-01-02T12:00:00.000Z',
        ],
    ];

    $mockClient = new MockClient([
        ListSalesInvoices::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new ListSalesInvoices);
    $mockClient->assertSent(ListSalesInvoices::class);

    $collection = collect($response->dto());

    expect($collection)->toHaveCount(2)
        ->and($collection->first())->toBeInstanceOf(SalesInvoice::class)
        ->and($collection->first()->id)->toBe('123456')
        ->and($collection->first()->invoice_id)->toBe('INV-2023-001')
        ->and($collection->first()->state)->toBe('open')
        ->and($collection->first()->reference)->toBe('Your reference')
        ->and($collection->last()->id)->toBe('789012')
        ->and($collection->last()->invoice_id)->toBe('INV-2023-002')
        ->and($collection->last()->state)->toBe('paid')
        ->and($collection->last()->reference)->toBe('Another reference');
});
