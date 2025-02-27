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
    // Create a mock response
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

    // Create a mock client that will intercept requests
    $mockClient = new MockClient([
        ListContacts::class => MockResponse::make($mockData, 200)
    ]);

    // Create a connector with the mock client
    $connector = new MoneybirdConnector();
    $connector->withMockClient($mockClient);

    // Make the request
    $request = new ListContacts();
    $response = $connector->send($request);
    
    // Check that we sent the intended request
    $mockClient->assertSent(ListContacts::class);
    
    // Verify the response data
    $collection = collect($request->createDtoFromResponse($response));
    expect($collection)->toHaveCount(2)
        ->and($collection->first())->toBeInstanceOf(Contact::class)
        ->and($collection->first()->id)->toBe('1')
        ->and($collection->first()->company_name)->toBe('Test Company')
        ->and($collection->first()->firstname)->toBe('John')
        ->and($collection->last()->id)->toBe('2')
        ->and($collection->last()->company_name)->toBe('Another Company');
});
