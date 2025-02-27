<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Contact;
use Sensson\Moneybird\Requests\Contacts\GetContact;
use Sensson\Moneybird\Requests\Contacts\ListContacts;
use Sensson\Moneybird\Resources\ContactsResource;

test('contacts resource is instantiated correctly', function () {
    $connector = new MoneybirdConnector();
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
        ListContacts::class => MockResponse::make($mockData, 200)
    ]);

    // Create a connector with the mock client
    $connector = new MoneybirdConnector();
    $connector->withMockClient($mockClient);

    // Execute the request through the resource
    $response = $connector->contacts()->all();
    
    // Verify request was sent correctly
    $mockClient->assertSent(ListContacts::class);
    
    // Verify response data
    $contacts = Contact::collect($response->json());
    expect($contacts)->toHaveCount(2)
        ->and($contacts[0]->id)->toBe('1')
        ->and($contacts[0]->company_name)->toBe('Test Company')
        ->and($contacts[1]->id)->toBe('2')
        ->and($contacts[1]->company_name)->toBe('Another Company');
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
    $connector = new MoneybirdConnector();
    $connector->withMockClient($mockClient);

    // Execute the request through the resource
    $response = $connector->contacts()->get($contactId);
    
    // Verify request was sent correctly
    $mockClient->assertSent(GetContact::class);
    
    // Verify response data
    $contact = new Contact(...$response->json());
    expect($contact->id)->toBe($contactId)
        ->and($contact->company_name)->toBe('Test Company')
        ->and($contact->firstname)->toBe('John')
        ->and($contact->lastname)->toBe('Doe');
});