<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\Ledgers\ListLedgers;
use Sensson\Moneybird\Resources\LedgerResource;

test('ledger resource is instantiated correctly', function () {
    $connector = new MoneybirdConnector;
    $resource = $connector->ledgers();

    expect($resource)->toBeInstanceOf(LedgerResource::class);
});

test('all() calls the list ledgers request', function () {
    $mockClient = new MockClient([
        ListLedgers::class => MockResponse::make([]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new LedgerResource($connector))->all();

    $mockClient->assertSent(ListLedgers::class);
});
