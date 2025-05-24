<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\SalesInvoice;
use Sensson\Moneybird\Enums\DeliveryMethod;
use Sensson\Moneybird\Requests\SalesInvoices\CreateSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\DeleteSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\DownloadPdfSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\DownloadUblSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\FindSalesInvoiceByInvoiceId;
use Sensson\Moneybird\Requests\SalesInvoices\GetSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\ListSalesInvoices;
use Sensson\Moneybird\Requests\SalesInvoices\SendSalesInvoice;
use Sensson\Moneybird\Requests\SalesInvoices\UpdateSalesInvoice;
use Sensson\Moneybird\Resources\SalesInvoiceResource;

test('resource instantiation', function () {
    $connector = new MoneybirdConnector;
    $resource = new SalesInvoiceResource($connector);

    expect($resource)->toBeInstanceOf(SalesInvoiceResource::class);
});

test('all method sends list sales invoices request', function () {
    $mockClient = new MockClient([
        ListSalesInvoices::class => MockResponse::make([
            [
                'id' => '123456',
                'invoice_id' => 'INV-2023-001',
            ],
            [
                'id' => '789012',
                'invoice_id' => 'INV-2023-002',
            ],
        ], 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->all();

    $mockClient->assertSent(ListSalesInvoices::class);
    expect($result)->toHaveCount(2)
        ->and($result->first())->toBeInstanceOf(SalesInvoice::class)
        ->and($result->first()->id)->toBe('123456');
});

test('get method sends get sales invoice request', function () {
    $mockClient = new MockClient([
        GetSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
        ], 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->get('123456');

    $mockClient->assertSent(GetSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456');
});

test('findByInvoiceId method sends find sales invoice by invoice id request', function () {
    $mockClient = new MockClient([
        FindSalesInvoiceByInvoiceId::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
        ], 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->findByInvoiceId('INV-2023-001');

    $mockClient->assertSent(FindSalesInvoiceByInvoiceId::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->invoice_id)->toBe('INV-2023-001');
});

test('create method sends create sales invoice request', function () {
    $mockClient = new MockClient([
        CreateSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'contact_id' => '789012',
        ], 201),
    ]);

    $salesInvoice = new SalesInvoice(contact_id: '789012');
    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->create($salesInvoice);

    $mockClient->assertSent(CreateSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->contact_id)->toBe('789012');
});

test('update method sends update sales invoice request', function () {
    $mockClient = new MockClient([
        UpdateSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'reference' => 'Updated reference',
        ], 200),
    ]);

    $salesInvoice = new SalesInvoice(reference: 'Updated reference');
    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->update('123456', $salesInvoice);

    $mockClient->assertSent(UpdateSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->reference)->toBe('Updated reference');
});

test('delete method sends delete sales invoice request', function () {
    $mockClient = new MockClient([
        DeleteSalesInvoice::class => MockResponse::make([], 204),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $resource->delete('123456');

    $mockClient->assertSent(DeleteSalesInvoice::class);
});

test('downloadPdf method sends download pdf sales invoice request', function () {
    $mockPdfContent = '%PDF-1.5 mock pdf content';
    $mockClient = new MockClient([
        DownloadPdfSalesInvoice::class => MockResponse::make($mockPdfContent, 200, ['Content-Type' => 'application/pdf']),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->downloadPdf('123456');

    $mockClient->assertSent(DownloadPdfSalesInvoice::class);
    expect($result)->toBe($mockPdfContent);
});

test('downloadUbl method sends download ubl sales invoice request', function () {
    $mockUblContent = '<?xml version="1.0" encoding="UTF-8"?><Invoice>';
    $mockClient = new MockClient([
        DownloadUblSalesInvoice::class => MockResponse::make($mockUblContent, 200, ['Content-Type' => 'application/xml']),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->downloadUbl('123456');

    $mockClient->assertSent(DownloadUblSalesInvoice::class);
    expect($result)->toBe($mockUblContent);
});

test('send method sends send sales invoice request without delivery method', function () {
    $mockClient = new MockClient([
        SendSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'sent_at' => '2023-01-01 12:00:00',
        ], 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->send('123456');

    $mockClient->assertSent(SendSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->sent_at)->toBe('2023-01-01 12:00:00');
});

test('send method sends send sales invoice request with delivery method', function () {
    $mockClient = new MockClient([
        SendSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'sent_at' => '2023-01-01 12:00:00',
            'delivery_method' => DeliveryMethod::Email,
        ], 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->send('123456', DeliveryMethod::Email);

    $mockClient->assertSent(SendSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->sent_at)->toBe('2023-01-01 12:00:00')
        ->and($result->delivery_method)->toBe(DeliveryMethod::Email);
});
