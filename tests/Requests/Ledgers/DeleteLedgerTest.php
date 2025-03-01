<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Requests\Ledgers\DeleteLedger;

it('deletes a ledger', function () {
    $ledgerId = '123456';

    // Create a mock client that returns a 204 No Content response
    $mockClient = new MockClient([
        DeleteLedger::class => MockResponse::make([], 204),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new DeleteLedger($ledgerId));

    // Verify that the request was sent
    $mockClient->assertSent(DeleteLedger::class);

    // Verify the response status code
    expect($response->status())->toBe(204);
});
