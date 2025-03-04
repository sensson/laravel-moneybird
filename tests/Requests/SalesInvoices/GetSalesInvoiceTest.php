<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\SalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\GetSalesInvoice;

test('get sales invoice request has correct endpoint', function () {
    expect((new GetSalesInvoice('123456'))->resolveEndpoint())->toBe('sales_invoices/123456.json');
});

test('get sales invoice request uses GET method', function () {
    expect((new GetSalesInvoice('123456'))->getMethod())->toBe(Method::GET);
});

test('get sales invoice request returns a sales invoice', function () {
    $mockData = [
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
    ];

    $mockClient = new MockClient([
        GetSalesInvoice::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new GetSalesInvoice('123456'));
    $mockClient->assertSent(GetSalesInvoice::class);

    $salesInvoice = $response->dto();

    expect($salesInvoice)->toBeInstanceOf(SalesInvoice::class)
        ->and($salesInvoice->id)->toBe('123456')
        ->and($salesInvoice->invoice_id)->toBe('INV-2023-001')
        ->and($salesInvoice->state)->toBe('open')
        ->and($salesInvoice->reference)->toBe('Your reference');
});
