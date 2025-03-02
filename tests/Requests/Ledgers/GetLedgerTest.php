<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Ledger;
use Sensson\Moneybird\Enums\AccountType;
use Sensson\Moneybird\Requests\Ledgers\GetLedger;

test('get ledger request has correct endpoint', function () {
    expect((new GetLedger('123456'))->resolveEndpoint())->toBe('ledger_accounts/123456.json');
});

test('get ledger request uses GET method', function () {
    expect((new GetLedger('123456'))->getMethod())->toBe(Method::GET);
});

test('get ledger request returns a ledger data object', function () {
    $mockData = [
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
    ];

    $mockClient = new MockClient([
        GetLedger::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new GetLedger('123456'));
    $mockClient->assertSent(GetLedger::class);

    $ledger = $response->dto();

    expect($ledger)->toBeInstanceOf(Ledger::class)
        ->and($ledger->id)->toBe('123456')
        ->and($ledger->name)->toBe('Office Supplies')
        ->and($ledger->account_type)->toBe(AccountType::Expenses)
        ->and($ledger->allowed_document_types)->toBe(['purchase_invoice', 'general_journal_document']);
});