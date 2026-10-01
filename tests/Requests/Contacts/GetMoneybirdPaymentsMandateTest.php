<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\MoneybirdPaymentsMandate;
use Sensson\Moneybird\Requests\Contacts\GetMoneybirdPaymentsMandate;

test('get moneybird payments mandate request has correct endpoint', function () {
    expect((new GetMoneybirdPaymentsMandate('123456'))->resolveEndpoint())
        ->toBe('contacts/123456/moneybird_payments_mandate.json');
});

test('get moneybird payments mandate request uses get method', function () {
    expect((new GetMoneybirdPaymentsMandate('123456'))->getMethod())->toBe(Method::GET);
});

test('get moneybird payments mandate request returns a mandate', function () {
    $mockClient = new MockClient([
        GetMoneybirdPaymentsMandate::class => MockResponse::make([
            'type' => 'ideal',
            'sepa_mandate' => true,
            'bank' => 'Test Bank',
            'iban' => 'NL81TEST0536169128',
            'bic' => 'TESTNL05',
            'iban_account_name' => 'E. Klaassen',
            'card_expiry_month' => null,
            'card_expiry_year' => null,
            'card_final_digits' => null,
            'created_at' => '2022-04-07T13:31:09.000Z',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $result = $connector->send(new GetMoneybirdPaymentsMandate('123456'))->dto();

    expect($result)->toBeInstanceOf(MoneybirdPaymentsMandate::class)
        ->and($result->sepa_mandate)->toBeTrue()
        ->and($result->iban)->toBe('NL81TEST0536169128');
});
