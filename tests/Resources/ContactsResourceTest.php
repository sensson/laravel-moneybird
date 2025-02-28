<?php

use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Contact;
use Sensson\Moneybird\Requests\Contacts\GetContact;
use Sensson\Moneybird\Requests\Contacts\ListContacts;
use Sensson\Moneybird\Resources\ContactsResource;

test('contacts resource is instantiated correctly', function () {
    $connector = new MoneybirdConnector;
    $resource = $connector->contacts();

    expect($resource)->toBeInstanceOf(ContactsResource::class);
});

test('contacts resource all method sends list contacts request', function () {
    $mockData = [
        [
            'id' => '1',
            'administration_id' => '123456',
            'company_name' => 'Test Company',
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
        ListContacts::class => MockResponse::make($mockData, 200),
    ]);

    // Create a connector with the mock client
    $connector = new MoneybirdConnector;
    $connector->withMockClient($mockClient);

    // Execute the request through the resource
    $response = $connector->contacts()->all();

    // Verify request was sent correctly
    $mockClient->assertSent(ListContacts::class);

    // Verify response is a collection of Contact objects
    expect($response)->toBeInstanceOf(Collection::class)
        ->and($response)->toHaveCount(2)
        ->and($response[0])->toBeInstanceOf(Contact::class)
        ->and($response[0]->id)->toBe('1')
        ->and($response[0]->company_name)->toBe('Test Company')
        ->and($response[1]->id)->toBe('2')
        ->and($response[1]->company_name)->toBe('Another Company');
});

test('contacts resource all method supports query parameters', function () {
    $mockData = [
        [
            'id' => '1',
            'administration_id' => '123456',
            'company_name' => 'Test Company',
            'delivery_method' => 'Email',
            'created_at' => '2023-01-01T00:00:00.000Z',
            'updated_at' => '2023-01-01T00:00:00.000Z',
        ],
    ];

    // Create a mock client that will intercept requests
    $mockClient = new MockClient([
        ListContacts::class => MockResponse::make($mockData, 200),
    ]);

    // Create a connector with the mock client
    $connector = new MoneybirdConnector;
    $connector->withMockClient($mockClient);

    // Execute the request through the resource with query parameters
    $response = $connector->contacts()->all(
        perPage: 10,
        page: 1,
        query: 'Test Company',
        includeArchived: true,
        todo: 'Follow up'
    );

    // Verify request was sent correctly with query parameters
    $mockClient->assertSent(function (ListContacts $request) {
        $query = $request->query()->all();

        return $query['per_page'] === 10
            && $query['page'] === 1
            && $query['query'] === 'Test Company'
            && $query['include_archived'] === true
            && $query['todo'] === 'Follow up';
    });

    // Verify response is a collection of Contact objects
    expect($response)->toBeInstanceOf(Collection::class)
        ->and($response)->toHaveCount(1)
        ->and($response[0])->toBeInstanceOf(Contact::class)
        ->and($response[0]->id)->toBe('1')
        ->and($response[0]->company_name)->toBe('Test Company');
});

test('contacts resource all method excludes null parameters from query', function () {
    $mockData = [
        [
            'id' => '1',
            'administration_id' => '123456',
            'company_name' => 'Test Company',
            'delivery_method' => 'Email',
            'created_at' => '2023-01-01T00:00:00.000Z',
            'updated_at' => '2023-01-01T00:00:00.000Z',
        ],
    ];

    // Create a mock client that will intercept requests
    $mockClient = new MockClient([
        ListContacts::class => MockResponse::make($mockData, 200),
    ]);

    // Create a connector with the mock client
    $connector = new MoneybirdConnector;
    $connector->withMockClient($mockClient);

    // Execute the request with some parameters as null
    $response = $connector->contacts()->all(
        perPage: 15,
        includeArchived: false,
    );

    // Verify only non-null parameters are included in the query
    $mockClient->assertSent(function (ListContacts $request) {
        $query = $request->query()->all();

        return $query['per_page'] === 15
            && $query['include_archived'] === false
            && ! isset($query['page'])
            && ! isset($query['query'])
            && ! isset($query['todo']);
    });

    // Verify response is a collection of Contact objects
    expect($response)->toBeInstanceOf(Collection::class)
        ->and($response[0])->toBeInstanceOf(Contact::class);
});

test('contacts resource get method sends get contact request with correct id', function () {
    $contactId = '12345';
    $mockData = [
        'id' => $contactId,
        'administration_id' => '123456',
        'company_name' => 'Test Company',
        'firstname' => 'John',
        'lastname' => 'Doe',
        'delivery_method' => 'Email',
        'created_at' => '2023-01-01T00:00:00.000Z',
        'updated_at' => '2023-01-01T00:00:00.000Z',
    ];

    // Create a mock client that will intercept requests
    $mockClient = new MockClient([
        GetContact::class => MockResponse::make($mockData, 200),
    ]);

    // Create a connector with the mock client
    $connector = new MoneybirdConnector;
    $connector->withMockClient($mockClient);

    // Execute the request through the resource
    $response = $connector->contacts()->get($contactId);

    // Verify request was sent correctly
    $mockClient->assertSent(GetContact::class);

    // Verify response is a Contact object with correct data
    expect($response)->toBeInstanceOf(Contact::class)
        ->and($response->id)->toBe($contactId)
        ->and($response->company_name)->toBe('Test Company')
        ->and($response->firstname)->toBe('John')
        ->and($response->lastname)->toBe('Doe');
});
