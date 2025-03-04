<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\SalesInvoices\DeleteSalesInvoice;

test('delete sales invoice request has correct endpoint', function () {
    expect((new DeleteSalesInvoice('123456'))->resolveEndpoint())->toBe('sales_invoices/123456.json');
});

test('delete sales invoice request uses DELETE method', function () {
    expect((new DeleteSalesInvoice('123456'))->getMethod())->toBe(Method::DELETE);
});

test('delete sales invoice request sends a request', function () {
    $mockClient = new MockClient([
        DeleteSalesInvoice::class => MockResponse::make([], 204),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $connector->send(new DeleteSalesInvoice('123456'));
    $mockClient->assertSent(DeleteSalesInvoice::class);
});
