<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\SalesInvoices\DownloadPdfSalesInvoice;

test('download pdf sales invoice request has correct endpoint', function () {
    expect((new DownloadPdfSalesInvoice('123456'))->resolveEndpoint())->toBe('sales_invoices/123456/download_pdf');
});

test('download pdf sales invoice request uses GET method', function () {
    expect((new DownloadPdfSalesInvoice('123456'))->getMethod())->toBe(Method::GET);
});

test('download pdf sales invoice request returns pdf content', function () {
    $mockPdfContent = '%PDF-1.5 mock pdf content';

    $mockClient = new MockClient([
        DownloadPdfSalesInvoice::class => MockResponse::make($mockPdfContent, 200, ['Content-Type' => 'application/pdf']),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new DownloadPdfSalesInvoice('123456'));
    $mockClient->assertSent(DownloadPdfSalesInvoice::class);

    $pdfContent = $response->dto();

    expect($pdfContent)->toBe($mockPdfContent);
});
