<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\SalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\UpdateSalesInvoice;

test('update sales invoice request has correct endpoint', function () {
    $salesInvoice = new SalesInvoice(contact_id: '789012');
    expect((new UpdateSalesInvoice('123456', $salesInvoice))->resolveEndpoint())->toBe('sales_invoices/123456.json');
});

test('update sales invoice request uses PATCH method', function () {
    $salesInvoice = new SalesInvoice(contact_id: '789012');
    expect((new UpdateSalesInvoice('123456', $salesInvoice))->getMethod())->toBe(Method::PATCH);
});

test('update sales invoice request returns a sales invoice', function () {
    $salesInvoice = new SalesInvoice(
        reference: 'Updated reference',
        due_date: '2023-02-28',
    );

    $mockData = [
        'id' => '123456',
        'administration_id' => '654321',
        'contact_id' => '789012',
        'invoice_id' => 'INV-2023-001',
        'state' => 'open',
        'invoice_date' => '2023-01-01',
        'due_date' => '2023-02-28',
        'reference' => 'Updated reference',
        'created_at' => '2023-01-01T12:00:00.000Z',
        'updated_at' => '2023-01-05T12:00:00.000Z',
    ];

    $mockClient = new MockClient([
        UpdateSalesInvoice::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new UpdateSalesInvoice('123456', $salesInvoice));
    $mockClient->assertSent(UpdateSalesInvoice::class);

    $updatedSalesInvoice = $response->dto();

    expect($updatedSalesInvoice)->toBeInstanceOf(SalesInvoice::class)
        ->and($updatedSalesInvoice->id)->toBe('123456')
        ->and($updatedSalesInvoice->invoice_id)->toBe('INV-2023-001')
        ->and($updatedSalesInvoice->state)->toBe('open')
        ->and($updatedSalesInvoice->reference)->toBe('Updated reference')
        ->and($updatedSalesInvoice->due_date)->toBe('2023-02-28');
});

test('update sales invoice request includes correct data in body', function () {
    $salesInvoice = new SalesInvoice(
        reference: 'Updated reference',
        due_date: '2023-02-28',
    );

    $mockClient = new MockClient([
        UpdateSalesInvoice::class => function ($request) {
            $body = json_decode($request->body(), true);
            expect($body)->toHaveKey('sales_invoice')
                ->and($body['sales_invoice'])->toHaveKey('reference', 'Updated reference')
                ->and($body['sales_invoice'])->toHaveKey('due_date', '2023-02-28');

            return MockResponse::make([], 200);
        },
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $connector->send(new UpdateSalesInvoice('123456', $salesInvoice));
    $mockClient->assertSent(UpdateSalesInvoice::class);
});
