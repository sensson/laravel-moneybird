<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\CustomFieldAttribute;
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
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->all();

    $mockClient->assertSent(ListSalesInvoices::class);
    expect($result)->toHaveCount(2)
        ->and($result->first())->toBeInstanceOf(SalesInvoice::class)
        ->and($result->first()->id)->toBe('123456');
});

test('all method retrieves sales invoices with custom_fields', function () {
    $mockClient = new MockClient([
        ListSalesInvoices::class => MockResponse::make([
            [
                'id' => '123456',
                'invoice_id' => 'INV-2023-001',
                'custom_fields' => [
                    [
                        'id' => 123,
                        'value' => 'Field Value 1',
                    ],
                    [
                        'id' => 456,
                        'value' => 'Field Value 2',
                    ],
                ],
            ],
            [
                'id' => '789012',
                'invoice_id' => 'INV-2023-002',
                'custom_fields' => [
                    [
                        'id' => 123,
                        'value' => 'Field Value 3',
                    ],
                    [
                        'id' => 456,
                        'value' => 'Field Value 4',
                    ],
                ],
            ],
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->all();

    $mockClient->assertSent(ListSalesInvoices::class);
    expect($result)->toHaveCount(2)
        ->and($result->first())->toBeInstanceOf(SalesInvoice::class)
        ->and($result->first()->id)->toBe('123456')
        ->and($result->first()->custom_fields)->toHaveCount(2)
        ->and($result->first()->custom_fields[0]->id)->toBe(123)
        ->and($result->first()->custom_fields[0]->value)->toBe('Field Value 1')
        ->and($result->first()->custom_fields[1]->id)->toBe(456)
        ->and($result->first()->custom_fields[1]->value)->toBe('Field Value 2')
        ->and($result->last()->id)->toBe('789012')
        ->and($result->last()->custom_fields)->toHaveCount(2)
        ->and($result->last()->custom_fields[0]->id)->toBe(123)
        ->and($result->last()->custom_fields[0]->value)->toBe('Field Value 3')
        ->and($result->last()->custom_fields[1]->id)->toBe(456)
        ->and($result->last()->custom_fields[1]->value)->toBe('Field Value 4');
});

test('get method sends get sales invoice request', function () {
    $mockClient = new MockClient([
        GetSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->get('123456');

    $mockClient->assertSent(GetSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456');
});

test('get method retrieves sales invoice with custom_fields', function () {
    $mockClient = new MockClient([
        GetSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'custom_fields' => [
                [
                    'id' => 123,
                    'value' => 'Field Value 1',
                ],
                [
                    'id' => 456,
                    'value' => 'Field Value 2',
                ],
            ],
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->get('123456');

    $mockClient->assertSent(GetSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->custom_fields)->toHaveCount(2)
        ->and($result->custom_fields[0]->id)->toBe(123)
        ->and($result->custom_fields[0]->value)->toBe('Field Value 1')
        ->and($result->custom_fields[1]->id)->toBe(456)
        ->and($result->custom_fields[1]->value)->toBe('Field Value 2');
});

test('findByInvoiceId method sends find sales invoice by invoice id request', function () {
    $mockClient = new MockClient([
        FindSalesInvoiceByInvoiceId::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->findByInvoiceId('INV-2023-001');

    $mockClient->assertSent(FindSalesInvoiceByInvoiceId::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->invoice_id)->toBe('INV-2023-001');
});

test('findByInvoiceId method retrieves sales invoice with custom_fields', function () {
    $mockClient = new MockClient([
        FindSalesInvoiceByInvoiceId::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'custom_fields' => [
                [
                    'id' => 123,
                    'value' => 'Field Value 1',
                ],
                [
                    'id' => 456,
                    'value' => 'Field Value 2',
                ],
            ],
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->findByInvoiceId('INV-2023-001');

    $mockClient->assertSent(FindSalesInvoiceByInvoiceId::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->invoice_id)->toBe('INV-2023-001')
        ->and($result->custom_fields)->toHaveCount(2)
        ->and($result->custom_fields[0]->id)->toBe(123)
        ->and($result->custom_fields[0]->value)->toBe('Field Value 1')
        ->and($result->custom_fields[1]->id)->toBe(456)
        ->and($result->custom_fields[1]->value)->toBe('Field Value 2');
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

test('create method sends create sales invoice request with due_date', function () {
    $mockClient = new MockClient([
        CreateSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'contact_id' => '789012',
            'due_date' => '2023-01-14',
        ], 201),
    ]);

    $salesInvoice = new SalesInvoice(
        contact_id: '789012',
        due_date: '2023-01-14'
    );
    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->create($salesInvoice);

    $mockClient->assertSent(CreateSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->contact_id)->toBe('789012')
        ->and($result->due_date)->toBe('2023-01-14');
});

test('create method sends create sales invoice request with payment_conditions', function () {
    $mockClient = new MockClient([
        CreateSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'contact_id' => '789012',
            'payment_conditions' => 'Net 30 days',
        ], 201),
    ]);

    $salesInvoice = new SalesInvoice(
        contact_id: '789012',
        payment_conditions: 'Net 30 days'
    );
    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->create($salesInvoice);

    $mockClient->assertSent(CreateSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->contact_id)->toBe('789012')
        ->and($result->payment_conditions)->toBe('Net 30 days');
});

test('update method sends update sales invoice request', function () {
    $mockClient = new MockClient([
        UpdateSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'reference' => 'Updated reference',
        ]),
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

test('update method sends update sales invoice request with due_date', function () {
    $mockClient = new MockClient([
        UpdateSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'due_date' => '2023-01-30',
        ]),
    ]);

    $salesInvoice = new SalesInvoice(due_date: '2023-01-30');
    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->update('123456', $salesInvoice);

    $mockClient->assertSent(UpdateSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->due_date)->toBe('2023-01-30');
});

test('update method sends update sales invoice request with payment_conditions', function () {
    $mockClient = new MockClient([
        UpdateSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'payment_conditions' => 'Net 30 days',
        ]),
    ]);

    $salesInvoice = new SalesInvoice(payment_conditions: 'Net 30 days');
    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->update('123456', $salesInvoice);

    $mockClient->assertSent(UpdateSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->payment_conditions)->toBe('Net 30 days');
});

test('update method sends update sales invoice request with custom_fields', function () {
    $mockClient = new MockClient([
        UpdateSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'custom_fields' => [
                [
                    'id' => 123,
                    'value' => 'Updated Value 1',
                ],
                [
                    'id' => 456,
                    'value' => 'Updated Value 2',
                ],
            ],
        ]),
    ]);

    $salesInvoice = new SalesInvoice(
        custom_fields: [
            new CustomFieldAttribute(
                id: 123,
                value: 'Updated Value 1'
            ),
            new CustomFieldAttribute(
                id: 456,
                value: 'Updated Value 2'
            ),
        ]
    );
    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->update('123456', $salesInvoice);

    $mockClient->assertSent(UpdateSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->custom_fields)->toHaveCount(2)
        ->and($result->custom_fields[0]->id)->toBe(123)
        ->and($result->custom_fields[0]->value)->toBe('Updated Value 1')
        ->and($result->custom_fields[1]->id)->toBe(456)
        ->and($result->custom_fields[1]->value)->toBe('Updated Value 2');
});

test('create method sends create sales invoice request with custom_fields', function () {
    $mockClient = new MockClient([
        CreateSalesInvoice::class => MockResponse::make([
            'id' => '123456',
            'invoice_id' => 'INV-2023-001',
            'contact_id' => '789012',
            'custom_fields' => [
                [
                    'id' => 123,
                    'value' => 'Custom Value 1',
                ],
                [
                    'id' => 456,
                    'value' => 'Custom Value 2',
                ],
            ],
        ], 201),
    ]);

    $salesInvoice = new SalesInvoice(
        contact_id: '789012',
        custom_fields: [
            new CustomFieldAttribute(
                id: 123,
                value: 'Custom Value 1'
            ),
            new CustomFieldAttribute(
                id: 456,
                value: 'Custom Value 2'
            ),
        ]
    );
    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->create($salesInvoice);

    $mockClient->assertSent(CreateSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->contact_id)->toBe('789012')
        ->and($result->custom_fields)->toHaveCount(2)
        ->and($result->custom_fields[0]->id)->toBe(123)
        ->and($result->custom_fields[0]->value)->toBe('Custom Value 1')
        ->and($result->custom_fields[1]->id)->toBe(456)
        ->and($result->custom_fields[1]->value)->toBe('Custom Value 2');
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
        ]),
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
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $resource = new SalesInvoiceResource($connector);
    $result = $resource->send('123456', DeliveryMethod::Email);

    $mockClient->assertSent(SendSalesInvoice::class);
    expect($result)->toBeInstanceOf(SalesInvoice::class)
        ->and($result->id)->toBe('123456')
        ->and($result->sent_at)->toBe('2023-01-01 12:00:00');
});
