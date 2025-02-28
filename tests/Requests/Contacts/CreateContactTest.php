<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Sensson\Moneybird\Connectors\MoneybirdConnector;
use Sensson\Moneybird\Data\Contact;
use Sensson\Moneybird\Enums\DeliveryMethod;
use Sensson\Moneybird\Requests\Contacts\CreateContact;

it('creates a contact', function () {
    $contact = Contact::from([
        'company_name' => 'Acme Inc.',
        'firstname' => 'John',
        'lastname' => 'Doe',
        'delivery_method' => DeliveryMethod::Email,
        'email' => 'john@example.com',
        'send_invoices_to_email' => 'billing@acme.com',
        'send_estimates_to_email' => 'billing@acme.com',
    ]);

    $mockClient = new MockClient([
        CreateContact::class => MockResponse::make([
            ...$contact->toArray(),
            'id' => '1',
            'administration_id' => '123456789',
        ]),
    ]);

    $connector = (new MoneybirdConnector)->withMockClient($mockClient);
    $response = $connector->send(new CreateContact($contact));
    $mockClient->assertSent(CreateContact::class);

    $result = $response->dto();

    expect($result)->toBeInstanceOf(Contact::class)
        ->and($result->id)->toBe('1')
        ->and($result->administration_id)->toBe('123456789')
        ->and($result->company_name)->toBe('Acme Inc.')
        ->and($result->firstname)->toBe('John')
        ->and($result->lastname)->toBe('Doe')
        ->and($result->email)->toBe('john@example.com')
        ->and($result->delivery_method)->toBe(DeliveryMethod::Email)
        ->and($result->send_invoices_to_email)->toBe('billing@acme.com')
        ->and($result->send_estimates_to_email)->toBe('billing@acme.com');
});
