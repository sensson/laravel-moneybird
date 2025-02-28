<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Contact;
use Sensson\Moneybird\Requests\Contacts\GetContact;

test('get contact request has correct endpoint', function () {
    $contactId = '12345';
    expect((new GetContact($contactId))->resolveEndpoint())->toBe("contacts/{$contactId}.json");
});

test('get contact request uses GET method', function () {
    expect((new GetContact('12345'))->getMethod())->toBe(Method::GET);
});

test('get contact request returns contact data object', function () {
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

    // Make the request
    $request = new GetContact($contactId);
    $response = $connector->send($request);

    // Check that we sent the intended request and got the right response
    $mockClient->assertSent(GetContact::class);

    // Verify the response data
    $contact = $request->createDtoFromResponse($response);
    expect($contact)
        ->toBeInstanceOf(Contact::class)
        ->and($contact->id)->toBe($contactId)
        ->and($contact->company_name)->toBe('Test Company')
        ->and($contact->firstname)->toBe('John')
        ->and($contact->lastname)->toBe('Doe');
});
