<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\SalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\CreateSalesInvoice;

test('create sales invoice request has correct endpoint', function () {
    $salesInvoice = new SalesInvoice(contact_id: '789012');
    expect((new CreateSalesInvoice($salesInvoice))->resolveEndpoint())->toBe('sales_invoices.json');
});

test('create sales invoice request uses POST method', function () {
    $salesInvoice = new SalesInvoice(contact_id: '789012');
    expect((new CreateSalesInvoice($salesInvoice))->getMethod())->toBe(Method::POST);
});

test('create sales invoice request returns a sales invoice', function () {
    $salesInvoice = new SalesInvoice(
        contact_id: '789012',
        reference: 'Your reference',
        invoice_date: '2023-01-01',
        due_date: '2023-01-31',
        payment_conditions: 'Net 30 days',
    );

    $mockData = [
        'id' => '123456',
        'administration_id' => '654321',
        'contact_id' => '789012',
        'invoice_id' => 'INV-2023-001',
        'state' => 'draft',
        'invoice_date' => '2023-01-01',
        'due_date' => '2023-01-31',
        'payment_conditions' => 'Net 30 days',
        'reference' => 'Your reference',
        'created_at' => '2023-01-01T12:00:00.000Z',
        'updated_at' => '2023-01-01T12:00:00.000Z',
    ];

    $mockClient = new MockClient([
        CreateSalesInvoice::class => MockResponse::make($mockData, 201),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new CreateSalesInvoice($salesInvoice));
    $mockClient->assertSent(CreateSalesInvoice::class);

    $createdSalesInvoice = $response->dto();

    expect($createdSalesInvoice)->toBeInstanceOf(SalesInvoice::class)
        ->and($createdSalesInvoice->id)->toBe('123456')
        ->and($createdSalesInvoice->invoice_id)->toBe('INV-2023-001')
        ->and($createdSalesInvoice->state)->toBe('draft')
        ->and($createdSalesInvoice->reference)->toBe('Your reference')
        ->and($createdSalesInvoice->payment_conditions)->toBe('Net 30 days');
});

test('create sales invoice request includes correct data in body', function () {
    $salesInvoice = new SalesInvoice(
        contact_id: '789012',
        reference: 'Your reference',
        invoice_date: '2023-01-01',
        due_date: '2023-01-31',
        payment_conditions: 'Net 30 days',
    );

    $mockClient = new MockClient([
        CreateSalesInvoice::class => function ($request) {
            $body = json_decode($request->body(), true);
            expect($body)->toHaveKey('sales_invoice')
                ->and($body['sales_invoice'])->toHaveKey('contact_id', '789012')
                ->and($body['sales_invoice'])->toHaveKey('reference', 'Your reference')
                ->and($body['sales_invoice'])->toHaveKey('invoice_date', '2023-01-01')
                ->and($body['sales_invoice'])->toHaveKey('due_date', '2023-01-31')
                ->and($body['sales_invoice'])->toHaveKey('payment_conditions', 'Net 30 days');

            return MockResponse::make([], 201);
        },
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $connector->send(new CreateSalesInvoice($salesInvoice));
    $mockClient->assertSent(CreateSalesInvoice::class);
});
