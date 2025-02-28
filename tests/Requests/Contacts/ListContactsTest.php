<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Contact;
use Sensson\Moneybird\Requests\Contacts\ListContacts;

test('list contacts request has correct endpoint', function () {
    expect((new ListContacts)->resolveEndpoint())->toBe('contacts.json');
});

test('list contacts request uses GET method', function () {
    expect((new ListContacts)->getMethod())->toBe(Method::GET);
});

test('list contacts request returns data collection of contacts', function () {
    $mockData = [
        [
            'id' => '1',
            'administration_id' => '123456',
            'company_name' => 'Test Company',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'delivery_method' => 'Email',
            'created_at' => '2023-01-01T00:00:00.000Z',
            'updated_at' => '2023-01-01T00:00:00.000Z',
        ],
        [
            'id' => '2',
            'administration_id' => '123456',
            'company_name' => 'Another Company',
            'delivery_method' => 'Email',
            'created_at' => '2023-01-02T00:00:00.000Z',
            'updated_at' => '2023-01-02T00:00:00.000Z',
        ],
    ];

    $mockClient = new MockClient([
        ListContacts::class => MockResponse::make($mockData, 200),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new ListContacts);
    $mockClient->assertSent(ListContacts::class);

    $collection = collect($response->dto());

    expect($collection)->toHaveCount(2)
        ->and($collection->first())->toBeInstanceOf(Contact::class)
        ->and($collection->first()->id)->toBe('1')
        ->and($collection->first()->company_name)->toBe('Test Company')
        ->and($collection->first()->firstname)->toBe('John')
        ->and($collection->last()->id)->toBe('2')
        ->and($collection->last()->company_name)->toBe('Another Company');
});
