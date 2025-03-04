<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\SalesInvoices\DownloadUblSalesInvoice;

test('download ubl sales invoice request has correct endpoint', function () {
    expect((new DownloadUblSalesInvoice('123456'))->resolveEndpoint())->toBe('sales_invoices/123456/download_ubl');
});

test('download ubl sales invoice request uses GET method', function () {
    expect((new DownloadUblSalesInvoice('123456'))->getMethod())->toBe(Method::GET);
});

test('download ubl sales invoice request returns ubl content', function () {
    $mockUblContent = '<?xml version="1.0" encoding="UTF-8"?><Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2">';

    $mockClient = new MockClient([
        DownloadUblSalesInvoice::class => MockResponse::make($mockUblContent, 200, ['Content-Type' => 'application/xml']),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new DownloadUblSalesInvoice('123456'));
    $mockClient->assertSent(DownloadUblSalesInvoice::class);

    $ublContent = $response->dto();

    expect($ublContent)->toBe($mockUblContent);
});
