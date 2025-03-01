<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Ledger;
use Sensson\Moneybird\Enums\AccountType;
use Sensson\Moneybird\Requests\Ledgers\ListLedgers;

test('list ledgers request has correct endpoint', function () {
    expect((new ListLedgers)->resolveEndpoint())->toBe('ledger_accounts.json');
});

test('list ledgers request uses GET method', function () {
    expect((new ListLedgers)->getMethod())->toBe(Method::GET);
});

test('list ledgers request returns data collection of ledgers', function () {
    $mockData = [
        [
            'id' => '123456',
            'administration_id' => '654321',
            'name' => 'Office Supplies',
            'account_type' => 'expenses',
            'parent_id' => null,
            'allowed_document_types' => ['purchase_invoice', 'general_journal_document'],
            'taxonomy_item' => [],
            'financial_account_id' => null,
            'created_at' => '2023-01-01T12:00:00.000Z',
            'updated_at' => '2023-01-01T12:00:00.000Z',
        ],
        [
            'id' => '789012',
            'administration_id' => '654321',
            'name' => 'Sales Revenue',
            'account_type' => 'revenue',
            'parent_id' => null,
            'allowed_document_types' => ['sales_invoice'],
            'taxonomy_item' => [],
            'financial_account_id' => null,
            'created_at' => '2023-01-01T12:00:00.000Z',
            'updated_at' => '2023-01-01T12:00:00.000Z',
        ],
    ];

    $mockClient = new MockClient([
        ListLedgers::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new ListLedgers);
    $mockClient->assertSent(ListLedgers::class);

    $collection = collect($response->dto());

    expect($collection)->toHaveCount(2)
        ->and($collection->first())->toBeInstanceOf(Ledger::class)
        ->and($collection->first()->id)->toBe('123456')
        ->and($collection->first()->name)->toBe('Office Supplies')
        ->and($collection->first()->account_type)->toBe(AccountType::Expenses)
        ->and($collection->first()->allowed_document_types)->toBe(['purchase_invoice', 'general_journal_document'])
        ->and($collection->last()->id)->toBe('789012')
        ->and($collection->last()->name)->toBe('Sales Revenue')
        ->and($collection->last()->account_type)->toBe(AccountType::Revenue);
});
