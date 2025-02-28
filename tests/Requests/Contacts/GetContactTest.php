<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Contact;
use Sensson\Moneybird\Enums\DeliveryMethod;
use Sensson\Moneybird\Requests\Contacts\GetContact;

test('get contact request has correct endpoint', function () {
    $contactId = '12345';
    $endpoint = (new GetContact($contactId))->resolveEndpoint();

    expect($endpoint)->toBe("contacts/{$contactId}.json");
});

test('get contact request uses GET method', function () {
    $method = (new GetContact('12345'))->getMethod();

    expect($method)->toBe(Method::GET);
});

it('gets a contact', function () {
    $mockData = [
        'id' => '12345',
        'administration_id' => '123456',
        'company_name' => 'Test Company',
        'firstname' => 'John',
        'lastname' => 'Doe',
        'delivery_method' => DeliveryMethod::Email,
        'created_at' => '2023-01-01T00:00:00.000Z',
        'updated_at' => '2023-01-01T00:00:00.000Z',
    ];

    $mockClient = new MockClient([
        GetContact::class => MockResponse::make($mockData),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new GetContact('12345'));
    $mockClient->assertSent(GetContact::class);

    $contact = $response->dto();

    expect($contact)
        ->toBeInstanceOf(Contact::class)
        ->and($contact->id)->toBe('12345')
        ->and($contact->company_name)->toBe('Test Company')
        ->and($contact->firstname)->toBe('John')
        ->and($contact->lastname)->toBe('Doe');
});
