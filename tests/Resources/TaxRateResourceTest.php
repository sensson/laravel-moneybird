<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\TaxRates\ListTaxRates;
use Sensson\Moneybird\Resources\TaxRateResource;

test('tax rate resource is instantiated correctly', function () {
    $connector = new MoneybirdConnector;
    $resource = $connector->taxRates();

    expect($resource)->toBeInstanceOf(TaxRateResource::class);
});

test('all() calls the list tax rates request', function () {
    $mockClient = new MockClient([
        ListTaxRates::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new TaxRateResource($connector))->all();

    $mockClient->assertSent(ListTaxRates::class);
});

test('all() with pagination parameters', function () {
    $mockClient = new MockClient([
        ListTaxRates::class => function ($request) {
            expect($request->query()->all())->toEqual([
                'per_page' => 10,
                'page' => 2,
            ]);

            return MockResponse::make([]);
        },
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new TaxRateResource($connector))->all(10, 2);

    $mockClient->assertSent(ListTaxRates::class);
});

test('all() with filter parameter', function () {
    $mockClient = new MockClient([
        ListTaxRates::class => function ($request) {
            expect($request->query()->all())->toEqual([
                'filter' => 'active:true',
            ]);

            return MockResponse::make([]);
        },
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new TaxRateResource($connector))->all(null, null, 'active:true');

    $mockClient->assertSent(ListTaxRates::class);
});
