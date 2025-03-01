<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Ledger;
use Sensson\Moneybird\Enums\AccountType;
use Sensson\Moneybird\Requests\Ledgers\UpdateLedger;

it('updates a ledger', function () {
    $ledgerId = '123456';
    $ledger = Ledger::from([
        'name' => 'Updated Office Supplies',
        'account_type' => AccountType::Expenses,
        'allowed_document_types' => ['purchase_invoice', 'general_journal_document'],
    ]);

    $rgsCode = 'expense1';

    $mockClient = new MockClient([
        UpdateLedger::class => MockResponse::make([
            ...$ledger->toArray(),
            'id' => $ledgerId,
            'administration_id' => '654321',
            'created_at' => '2023-01-01T12:00:00.000Z',
            'updated_at' => '2023-01-02T12:00:00.000Z',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new UpdateLedger($ledgerId, $ledger, $rgsCode));
    $mockClient->assertSent(UpdateLedger::class);

    $result = $response->dto();

    expect($result)->toBeInstanceOf(Ledger::class)
        ->and($result->id)->toBe($ledgerId)
        ->and($result->administration_id)->toBe('654321')
        ->and($result->name)->toBe('Updated Office Supplies')
        ->and($result->account_type)->toBe(AccountType::Expenses)
        ->and($result->allowed_document_types)->toBe(['purchase_invoice', 'general_journal_document']);
});
