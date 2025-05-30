<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\TaxRate;
use Sensson\Moneybird\Enums\TaxRateType;
use Sensson\Moneybird\Requests\TaxRates\ListTaxRates;

test('list tax rates request has correct endpoint', function () {
    expect((new ListTaxRates)->resolveEndpoint())->toBe('tax_rates.json');
});

test('list tax rates request uses GET method', function () {
    expect((new ListTaxRates)->getMethod())->toBe(Method::GET);
});

test('list tax rates request returns data collection of tax rates', function () {
    $mockData = [
        [
            'id' => '123456',
            'administration_id' => '654321',
            'name' => 'VAT 21%',
            'partial_name' => 'BTW 21%',
            'percentage' => '21.0',
            'tax_rate_type' => 'sales_invoice',
            'show_tax' => true,
            'active' => true,
            'created_at' => '2023-01-01T12:00:00.000Z',
            'updated_at' => '2023-01-01T12:00:00.000Z',
        ],
        [
            'id' => '789012',
            'administration_id' => '654321',
            'name' => 'VAT 9%',
            'partial_name' => 'BTW 9%',
            'percentage' => '9.0',
            'tax_rate_type' => 'sales_invoice',
            'show_tax' => true,
            'active' => true,
            'created_at' => '2023-01-01T12:00:00.000Z',
            'updated_at' => '2023-01-01T12:00:00.000Z',
        ],
    ];

    $mockClient = new MockClient([
        ListTaxRates::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new ListTaxRates);
    $mockClient->assertSent(ListTaxRates::class);

    $collection = collect($response->dto());

    expect($collection)->toHaveCount(2)
        ->and($collection->first())->toBeInstanceOf(TaxRate::class)
        ->and($collection->first()->id)->toBe('123456')
        ->and($collection->first()->name)->toBe('VAT 21%')
        ->and($collection->first()->partial_name)->toBe('BTW 21%')
        ->and($collection->first()->percentage)->toBe('21.0')
        ->and($collection->first()->tax_rate_type)->toBe(TaxRateType::SalesInvoice)
        ->and($collection->first()->show_tax)->toBeTrue()
        ->and($collection->first()->active)->toBeTrue()
        ->and($collection->last()->id)->toBe('789012')
        ->and($collection->last()->name)->toBe('VAT 9%')
        ->and($collection->last()->percentage)->toBe('9.0')
        ->and($collection->last()->tax_rate_type)->toBe(TaxRateType::SalesInvoice);
});
