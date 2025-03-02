<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Ledger;
use Sensson\Moneybird\Enums\AccountType;
use Sensson\Moneybird\Requests\Ledgers\CreateLedger;
use Sensson\Moneybird\Requests\Ledgers\DeleteLedger;
use Sensson\Moneybird\Requests\Ledgers\GetLedger;
use Sensson\Moneybird\Requests\Ledgers\ListLedgers;
use Sensson\Moneybird\Requests\Ledgers\UpdateLedger;
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

test('get() calls the get ledger request', function () {
    $mockClient = new MockClient([
        GetLedger::class => MockResponse::make([
            'id' => '123456',
            'name' => 'Test Ledger',
            'account_type' => 'expenses',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new LedgerResource($connector))->get('123456');

    $mockClient->assertSent(GetLedger::class);
});

test('create() calls the create ledger request', function () {
    $mockClient = new MockClient([
        CreateLedger::class => MockResponse::make([
            'name' => 'Test Ledger',
            'account_type' => AccountType::Expenses,
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    $ledger = Ledger::from([
        'name' => 'Test Ledger',
        'account_type' => AccountType::Expenses,
    ]);

    (new LedgerResource($connector))->create($ledger, 'test-code');

    $mockClient->assertSent(CreateLedger::class);
});

test('update() calls the update ledger request', function () {
    $mockClient = new MockClient([
        UpdateLedger::class => MockResponse::make([
            'id' => '123456',
            'name' => 'Updated Ledger',
            'account_type' => AccountType::Expenses,
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    $ledger = Ledger::from([
        'name' => 'Updated Ledger',
        'account_type' => AccountType::Expenses,
    ]);

    (new LedgerResource($connector))->update('123456', $ledger, 'test-code');

    $mockClient->assertSent(UpdateLedger::class);
});

test('delete() calls the delete ledger request', function () {
    $mockClient = new MockClient([
        DeleteLedger::class => MockResponse::make([], 204),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);

    (new LedgerResource($connector))->delete('123456');

    $mockClient->assertSent(DeleteLedger::class);
});
