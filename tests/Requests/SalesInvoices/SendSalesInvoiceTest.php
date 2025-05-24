<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\SalesInvoice;
use Sensson\Moneybird\Enums\DeliveryMethod;
use Sensson\Moneybird\Requests\SalesInvoices\SendSalesInvoice;

test('send sales invoice request has correct endpoint', function () {
    expect((new SendSalesInvoice('123456'))->resolveEndpoint())->toBe('sales_invoices/123456/send_invoice.json');
});

test('send sales invoice request uses PATCH method', function () {
    expect((new SendSalesInvoice('123456'))->getMethod())->toBe(Method::PATCH);
});

test('send sales invoice request returns a sales invoice', function () {
    $mockData = [
        'id' => '123456',
        'administration_id' => '654321',
        'contact_id' => '789012',
        'invoice_id' => 'INV-2023-001',
        'state' => 'open',
        'invoice_date' => '2023-01-01',
        'due_date' => '2023-01-31',
        'sent_at' => '2023-01-01T12:00:00.000Z',
        'created_at' => '2023-01-01T12:00:00.000Z',
        'updated_at' => '2023-01-01T12:00:00.000Z',
    ];

    $mockClient = new MockClient([
        SendSalesInvoice::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new SendSalesInvoice('123456'));
    $mockClient->assertSent(SendSalesInvoice::class);

    $sentSalesInvoice = $response->dto();

    expect($sentSalesInvoice)->toBeInstanceOf(SalesInvoice::class)
        ->and($sentSalesInvoice->id)->toBe('123456')
        ->and($sentSalesInvoice->invoice_id)->toBe('INV-2023-001')
        ->and($sentSalesInvoice->state)->toBe('open')
        ->and($sentSalesInvoice->sent_at)->toBe('2023-01-01T12:00:00.000Z');
});

test('send sales invoice request with delivery method includes correct data in body', function () {
    $mockClient = new MockClient([
        SendSalesInvoice::class => function ($request) {
            $body = json_decode($request->body(), true);
            expect($body)->toHaveKey('delivery_method', 'Email');

            return MockResponse::make([], 200);
        },
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $connector->send(new SendSalesInvoice('123456', DeliveryMethod::Email));
    $mockClient->assertSent(SendSalesInvoice::class);
});

test('send sales invoice request without delivery method has empty body', function () {
    $mockClient = new MockClient([
        SendSalesInvoice::class => function ($request) {
            $body = json_decode($request->body(), true);
            expect($body)->toBeEmpty();

            return MockResponse::make([], 200);
        },
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $connector->send(new SendSalesInvoice('123456'));
    $mockClient->assertSent(SendSalesInvoice::class);
});
